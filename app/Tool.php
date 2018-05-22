<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ToolPart;
use App\Part;
use App\Tool_detail;
use App\Machine;
use App\Forecast;
use Carbon\Carbon;
use DB;

class Tool extends Model
{
    //
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $hidden = ['is_deleted', 'deleted_at', 'created_at', 'updated_at'];
    
    protected $casts = [ 
        'start_value' => 'integer', 
        'guarantee_shoot' => 'integer'
    ];
    
    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }

    public function parts(){
        return $this->belongsToMany('App\Part', 'tool_part')
        // ->withTimestamps()
        ->with('parentParts')
        ->withPivot('cavity', 'is_independent');
    }

    public function forecast($PartNo, $trans_date = null ){
        if (is_null($trans_date)) {
            $trans_date = date('Y-m-d');
        }

        $trans_date = Carbon::createFromFormat('Y-m-d', $trans_date )->format('Ymd');

        //make array of month here

        $forecast = Forecast::select(DB::raw('
            convert(varchar(10), convert(datetime, TransDate), 120) as trans_date,
            SuppCode,
            PartNo,
            DT4QT29 as month1,
            DT4QT30 as month2,
            DT4QT31 as month3,
            DT4QT32 as month4,
            DT4QT33 as month5,
            DT4QT34 as month6,
            (   
                cast(ltrim(DT4QT29) as int) + 
                cast(ltrim(DT4QT30) as int) + 
                cast(ltrim(DT4QT31) as int) + 
                cast(ltrim(DT4QT32) as int) + 
                cast(ltrim(DT4QT33) as int) + 
                cast(ltrim(DT4QT34) as int)
            )  as total
            
        '))->where('RT', '=', 'D' );

        $forecast = $forecast->whereRaw('rtrim(PartNo) = ?', [ trim($PartNo) ] )
        ->whereRaw('transdate = (
            select top 1
            convert(varchar(10), transdate, 101)
            from svrdbs.edi.dbo.forcast_date
            where convert(varchar(10), transdate, 112) <= ?
            order by convert(varchar(10), transdate, 112) desc
        )', [$trans_date] ); // ? = parameter yg akan diganti oleh trim($partNo)
        // ->whereRaw('convert(varchar(10), convert(datetime, TransDate), 112) <= ?', [$trans_date]);
        $forecast = $forecast->first();

        if (empty( $forecast) ) {
            //harus diset as object karena eloquent return nya object
            $forecast = (object) [
                'trans_date' => $trans_date,
                'SuppCode' => null,
                'PartNo' => $PartNo,
                'month1' => 0,
                'month2' => 0,
                'month3' => 0,
                'month4' => 0,
                'month5' => 0,
                'month6' => 0,
                'total' => 0
            ];
        }

        return $forecast;
    }

    public function partWithHighestTotalDelivery($trans_date = null){
        if (is_null($trans_date)) {
            $trans_date = date('Y-m-d');
        }

        $parts = $this->parts;

        $highest_total_delivery = 0;
        // setting variable for not suffix number
        $month1 = 0;
        $month2 = 0;
        $month3 = 0;
        $month4 = 0;
        $month5 = 0;
        $month6 = 0;
        $total = 0;


        //
        foreach ($parts as $key => $part) {
            $part->detail = $part->partDetail($trans_date); //get part_details
            

            $total_delivery = $part->first_value;

            if (isset( $part->detail->total_delivery )) {
                $total_delivery += $part->detail->total_delivery;     
            } else {
                //jika detail tidak ada detail, isi disini;
                if ( $part->parentParts->isEmpty() ) {

                    // $part->is_semi_part = false;
                    //cek apakah part->detail sudah diinput sebelumnya;
                    //kalau sudah, tidak usah input lagi;
                    if ($part->detail == null ) {
                        //pck31 method get expect partno, startDate, finish date as paramter;
                        $part->pck31 = $part->pck31($part->no, $part->date_of_first_value, $trans_date);
                        if ($part->pck31 != null ) {
                            # code...
                            //save result into part details
                            $part_detail = new Part_detail;
                            $part_detail->part_id = $part->id;
                            $part_detail->total_delivery = $part->pck31->total_qty;
                            //total qty = data.part.total_delivery+data.forecast.total
                            $part_detail->total_qty = 0;
                            $part_detail->trans_date = $trans_date;
                            $part_detail->save();

                            //benerin total_delivery nya. karena tool.part.detail masih kosong.
                            //$tool->part->total_delivery += $part->pck31->total_qty;
                        }
                    }
                    
                }else {
                    //semi part disini;
                    //setup value awal untuk save ke detail
                    if ($part->detail == null) { //kalau kosong, ga kosong mah gausah diisi,
                        //kalau ga kosong artinya user salah isi parameter. 

                        /*
                            kalau ga kosong, itu artinya data part "yg katanya" semi part itu bkn benar2 semi part karena datanya ada di pck31. sedangkan semi part itu pasti tidak ada di pck31, dan tidak ada di forecast;
                        */

                        $tmpTotalDelivery = 0;

                        foreach ($part->parentParts as $key => $parentPart ) {
                            $parentPart->parentPart->detail; //get the detail

                            if ($parentPart->parentPart->detail == null ) {
                                //pck31 method get expect partno, startDate, finish date as paramter;
                                $part->pck31 = $part->pck31($parentPart->parentPart->no, $parentPart->parentPart->date_of_first_value, $trans_date  );
                                if ($part->pck31 != null ) {
                                    # code...
                                    $tmpTotalDelivery += $part->pck31->total_qty;
                                }
                            }else {
                                
                                $part->pck31 = (object) [ 
                                    'total_delivery' => $parentPart->parentPart->detail->total_delivery 
                                ];
                                //kalau detail ada, total delivery diambil dari details
                                $tmpTotalDelivery += $parentPart->parentPart->detail->total_delivery;
                            }
                        }

                        //$part->aku_semi_part = true;

                        //if $tmpTotalDelivery masih 0 artinya di parent part, tidak ada pck31;
                        if ($tmpTotalDelivery != 0) {
                            //save part into part details
                            $part_detail = new Part_detail;
                            // important note!
                            //save detail ke part id, bkn ke parentpart.id karena memang kita cuman ngambil data sj di parent, store nya tetep di child part;
                            $part_detail->part_id = $part->id;
                            $part_detail->total_delivery = $tmpTotalDelivery;//$part->pck31->total_qty;
                            $part_detail->total_qty = 0;//$part->id;
                            $part_detail->trans_date = $trans_date;
                            $part_detail->save();
                        }


                    }
                }

                //get detail lagi, siapa tau sudah diset dr pck31;
                $part->detail;
                if (isset( $part->detail->total_delivery )) {
                    $total_delivery += $part->detail->total_delivery;     
                } 
            }

            /*there will be a serious problem if user set two part suffix and not suffix in the same tools. the result of this logic will not apply properly*/

            //cek if it's suffix number or not
            if ($part->pivot->is_independent == "0" || $part->pivot->is_independent == 0 ) {
                if ($highest_total_delivery < $total_delivery ) {
                   $highest_total_delivery = $total_delivery;
                   $partResult = $part;
                }
            }else {
                $partResult = $part;
                $highest_total_delivery += $total_delivery;
                //if it's not suffix number, get the forecast, then summary
                $forecast = $this->forecast($part->no, $trans_date );
                if ($forecast != null) {
                    # code...
                    $month1 += $forecast->month1;
                    $month2 += $forecast->month2;
                    $month3 += $forecast->month3;
                    $month4 += $forecast->month4;
                    $month5 += $forecast->month5;
                    $month6 += $forecast->month6;
                    $total += $forecast->total;
                    $PartNo = $forecast->PartNo;
                }
            }

            if(! isset($partResult)){
                // ini ditambahkan karena kalau nerima trans_date, program error. $partResult ga ter defined di coding sebelumya
                $partResult = $part; 
            }
            // inilah letak kesalahannya. part selalu return yang terakhir, bkn yg memiliki total delivery paling tinggi!
            $partResult->total_delivery = $highest_total_delivery;
            //ceil itu pembulatan ke atas. in case hasilnya 12.5 maka akan jadi 13;
            $partResult->total_shoot_based_on_part = ceil($highest_total_delivery / (float) $partResult->pivot->cavity) ;
            $result = $partResult;
        }

        //what happen if result == null ??
        if (!isset($result)) {
            $result = null;
        }

        //get forecast
        if ($result->pivot->is_independent == "0" || $result->pivot->is_independent == 0 ) {
            $this->forecast = $this->forecast($result->no , $trans_date );

            /*important note: $this->forecast method return value with suppCode null if the forecast not found;*/

            //jika forecast kosong dan parent part tersedia, maka isi forecast based parent part, bukan children part;
            if ($this->forecast->SuppCode == null && $result->parentParts->isNotEmpty() ) {
                // setting variable for not suffix number      

                $month1 = 0;
                $month2 = 0;
                $month3 = 0;
                $month4 = 0;
                $month5 = 0;
                $month6 = 0;
                $total = 0;
                $SuppCode = '';
                $PartNo = '';

                //$this->hasil = $result->parentParts[0]->parentPart;
                //
                foreach ($result->parentParts as $key => $parentPart ) {
                    //get by the part model method, not the result the model gave.
                    $parentPartPartNo = $parentPart->parentPart->no;
                    $forecast = $this->forecast($parentPartPartNo , $trans_date );
                    if ($forecast != null) {
                        # disini, bisa saja user tidak setting suppCode yg sama. which is seharusnya tidak bisa. kita bisa maksimalkan untuk cek apakah data yang diinput sudah sesuai atau tidak;
                        $month1 += $forecast->month1;
                        $month2 += $forecast->month2;
                        $month3 += $forecast->month3;
                        $month4 += $forecast->month4;
                        $month5 += $forecast->month5;
                        $month6 += $forecast->month6;
                        $total += $forecast->total;
                        $PartNo += $forecast->PartNo;
                        $SuppCode += $forecast->SuppCode;
                    }
                }    

                $this->forecast = (object) [
                    'trans_date' => $trans_date,
                    'SuppCode' => $SuppCode,
                    'PartNo' => $PartNo,
                    'month1' => $month1,
                    'month2' => $month2,
                    'month3' => $month3,
                    'month4' => $month4,
                    'month5' => $month5,
                    'month6' => $month6,
                    'total' => $total
                ];
            }
        }else {
            //setup forecast untuk yang suffix number
            $this->forecast = (object) [
                'trans_date' => $trans_date,
                'SuppCode' => null,
                'PartNo' => $PartNo,
                'month1' => $month1,
                'month2' => $month2,
                'month3' => $month3,
                'month4' => $month4,
                'month5' => $month5,
                'month6' => $month6,
                'total' => $total
            ];
        }

        $this->part = $result;
    }
        
    public function toolpart(){
        $id = $this->id;

        $toolpart = ToolPart::where('tool_id', '=', $id )->get();
        $toolpart->each(function($model){
            //get the highest total shoot
            $model->parts();
            $model->tools();

        });

        $this->toolpart = $toolpart;

        return $this;
    }

    public function machines(){
        return $this->hasMany('App\Machine');
    }

    public function hasToolPart(){
        $toolpart = ToolPart::where('tool_id', '=', $this->id )->get();
        return !$toolpart->isEmpty(); //return true if it's not empty
    }

    public function details($trans_date = null){ //get all detail
        return $this->hasMany('App\Tool_detail');
    }

    public function detail($trans_date = null){ //get all detail
        if (is_null($trans_date)) {
            $trans_date = date('Y-m-d');
        }

        return $this->hasOne('App\Tool_detail')
        ->where('trans_date', $trans_date )
        ->orderBy('total_shoot', 'desc');
    }

    public function getHighestTotalShoot(){
        return $this->hasOne('App\Tool_detail')->orderBy('total_shoot', 'desc');
    }

    protected static function boot() { //cascade on soft delete
        parent::boot();

        static::deleting(function($tool) {
            $id = $tool->id;
            $toolpart = ToolPart::where('tool_id', '=', $id )->get();
            $toolpart->each(function($model){
                $model->delete();
            });
            
        });
    }
}
