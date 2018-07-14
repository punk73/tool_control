<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Api\V1\Controllers\CsvController;
use App\ToolPart;
use App\Supplier;
use App\Part;
use App\Tool;

class ImportCavity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cavities {filename=Cavity.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'it will import cavity from csv file that store in web storage';

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
            $errorFound = 0;
            $record = [];
            for ($i = 0; $i < count($importedCsv); $i++)
            {   
                // loading nambah;
                $bar->advance();
                $this->info (print_r($importedCsv[$i]));

                $part = Part::where('no', 'like', $importedCsv[$i]['part_no'] . '%' )
                ->with(['supplier:id,name,code'])
                ->first();                     
                if (is_null( $part)) {
                    // kalau part tidak ditemukan masuk kesini
                    $record[] = [
                        'part_no' => $importedCsv[$i]['part_no'],
                        'message' => 'part number not found'
                    ];
                    $errorFound++;
                    $this->error( $importedCsv[$i]['part_no'] . ' not found ');
                    continue;
                }
                $part_id = $part->id; //set part id to input

                // cek if this tools is exists
                if(! Tool::where('no', 'like', $importedCsv[$i]['tool_no'].'%' )
                ->with(['supplier:id,name,code'])
                ->exists()){
                    $record[] = [
                        'tool_no' => $importedCsv[$i]['tool_no'],
                        'message' => 'tool number not found'
                    ];
                    $errorFound++;
                    $this->error( $importedCsv[$i]['tool_no'] . ' not found ');
                    continue;
                }

                $tool = Tool::where('no', 'like', $importedCsv[$i]['tool_no'].'%' )
                ->with(['supplier:id,name,code'])
                ->first();

                $tool_id = $tool->id; //set tool id to input


                // cek apakah part_id ada di supplier yg di pass
                //cek apakah tool_id & part_id ada di supplier yg di pass 
                if ( $part->supplier->id !== $tool->supplier->id ) {
                    $record = [
                        'part' => $part,
                        'tool' => $tool,
                        
                        'message' => 'part & tool is from two difference supplier!'
                    ];
                    $records[]=$record;
                    $this->error('tool & part is from different supplier');
                    $errorFound++;
                    continue;                  
                }

                $cavity = $importedCsv[$i]['cavity'];
                /*user input is suffix number, di db is independent*/
                $is_independent = $importedCsv[$i]['is_suffix_number']; 

                
                $record = ToolPart::updateOrCreate([
                    'part_id' => $part_id,
                    'tool_id' => $tool_id,
                ], [
                    'part_id' => $part_id,
                    'tool_id' => $tool_id,
                    'cavity' => $cavity,
                    'is_independent' => $is_independent,
                ]);

                $this->info (print_r([
                    'part_id' => $part_id,
                    'tool_id' => $tool_id,
                    'cavity' => $cavity,
                    'is_independent' => $is_independent,
                ]));

                $records[]=$record;
                /*kalau ada update, kalau ga ada, ngesave*/
            }
        }

        $bar->finish();
    }
}
