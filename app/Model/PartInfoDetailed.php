<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PartInfoDetailed
 * @package App
 */
class PartInfoDetailed extends Model
{
    //
    protected $table = "part_info_detailed";
    protected $guarded = [];
    public $timestamps = true;


    public static function SpareWarehousingRecord($put_storage_no)
    {
        return self::from('part_info_detailed as pid')
            ->join('part_info as pi' , 'pid.part_id','=','pi.id')
            ->where(['put_storage_no'=>$put_storage_no])->get();
    }
}
