<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Api\V1\Controllers\CsvController;
use App\Supplier;
use App\Tool;

class ImportTools extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tools {filename=Tools.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'it will import tools from csv file that store in web storage';

    // protected $path = ;
    // protected $filename = 'Parts.csv';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){   
        

        //import file parts;
        $path = storage_path('master');
        $fullname = $path .'\\'. $this->argument('filename');

        if (!file_exists($fullname)) {
            $this->error('File '. $this->argument('filename') .' not Found!');
            return;            
        }

        $this->doImport($fullname);

        // if everything goes right!
        $this->info($this->argument('filename').' is Imported!!');

    }

    public function doImport($fullname){
        $csv = new CsvController();
        $importedCsv = $csv->csvToArray($fullname);
        $bar = $this->output->createProgressBar(count($importedCsv));

        if ($importedCsv) { //kalau something wrong ini bakal bernilai false
            for ($i = 0; $i < count($importedCsv); $i++)
            {   
                // loading nambah;
                $bar->advance();
                
                // first parameter is data to check, second is data to input
                $no =  rtrim( $importedCsv[$i]['no']); //ini di trim kanan
                
                if ($no == '') {
                    continue;
                }

                $name =  $importedCsv[$i]['name'];
                $supplier = Supplier::select('id')->where('name', 'like', trim($importedCsv[$i]['supplier_name']) .'%' )->first();
                if(is_null($supplier)){ //supplier tidak ditemukan;
                    $this->error( $importedCsv[$i]['supplier_name'] . ' supplier name not found');
                    continue;
                }

                $supplier_id = (integer) $supplier->id;
                
                $no_of_tooling = $importedCsv[$i]['no_of_tooling'];
                $start_value = $importedCsv[$i]['start_value'];
                $start_value_date = $importedCsv[$i]['start_value_date'];
                $guarantee_shoot = $importedCsv[$i]['guarantee_shoot'];
                $delivery_date = $importedCsv[$i]['delivery_date'];
                

                $record = Tool::updateOrCreate([
                    ['no', 'like', $no . '%' ],
                ], [
                    'no' => $no,
                    'name' => $name,
                    'supplier_id' => $supplier_id,
                    'no_of_tooling' => $no_of_tooling,
                    'start_value' => $start_value,
                    'start_value_date' => $start_value_date,
                    'guarantee_shoot' => $guarantee_shoot,
                    'delivery_date' => $delivery_date,

                ]);

                $records[]=$record;
                /*kalau ada update, kalau ga ada, ngesave*/
            }
        }

        $bar->finish();
    }
}
