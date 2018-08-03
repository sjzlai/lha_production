<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PartInfo
 * @package App\Model
 * @name:零部件信息模型
 * @author: weikai
 * @date: 2018/6/26 16:16
 */
class PartInfo extends Model
{
    protected $table = "part_info";
    protected $guarded = [];
    public $timestamps = true;

    /**
     * @name:模糊搜索
     * @author: weikai
     * @date: 2018/7/10 10:01
     */
    public static function fuzzySearch($value,$key = 'part_name')
    {
        return PartInfo::where($key,'=',$value)
            ->Leftjoin('part_info_detailed as pid' ,'part_info.id','=','pid.part_id')
            ->get();

    }
}
