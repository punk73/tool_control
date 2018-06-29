<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Api\V1\Controllers\CsvController;
use App\Supplier;
use App\Part;

class ImportParts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:parts {filename=Parts.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'it will import part from csv file that store in web storage';

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
    public function handle()
    {   
        

        //import file parts;
        $path = storage_path('master');
        $fullname = $path .'\\'. $this->argument('filename');

        // echo $fullname;
        // return;

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
                $name =  $importedCsv[$i]['name'];
                $supplier = Supplier::select('id')->where('code', 'like', $importedCsv[$i]['supplier_code'] .'%' )->first();
                
                if(is_null($supplier)){ //supplier tidak ditemukan;
                    continue;
                }

                $supplier_id = (integer) $supplier->id;
                // return $supplier_id;
                $model = $importedCsv[$i]['model'];
                $first_value = $importedCsv[$i]['first_value'];
                $date_of_first_value = $importedCsv[$i]['date_of_first_value'];

                $record = Part::updateOrCreate([
                    ['no', 'like', $no . '%' ],
                ], [
                    'no' => $no,
                    'name' => $name,
                    'supplier_id' => $supplier_id,
                    'model' => $model,
                    'first_value' => $first_value,
                    'date_of_first_value' => $date_of_first_value,
                ]);
                $records[]=$record;
                /*kalau ada update, kalau ga ada, ngesave*/
            }
        }

        $bar->finish();

        // if everything goes right!
        $this->info($this->argument('filename').' is Imported!!');

    }
}
