<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShelfHasPart
 * @package App\Model
 * @name:货架产品关联
 * @author: 
 * @date: 2018/7/17 11:28
 */
class ShelfHasPart extends Model
{
    protected $table = 'shelf_has_part';
    protected $guarded = [];
    public $timestamps = true;

    /**
     * Notes: 查询库存列表
     * Author:sjzlai
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * Date:2018/08/08 11:03
     */
    public static function PartRecordInfo()
    {
        return self::from('shelf_has_part as shp')
            ->select('shp.*','pi.id as pid','pi.part_name','shelf.id as shelf_id','shelf.shelf_name','shelf.storageroom_id','room.id as room_id','room.store_name')
            ->join('part_info as pi' , 'shp.part_id','=','pi.id')
            ->join('shelf_info as shelf','shelf.id','=','shp.shelf_id')
            ->join('storageroom_info as room','shelf.storageroom_id','=','room.id')
            ->get();
    }


    /**
     * Notes:根据id查询相关联库房,货架,名称,数量详细信息
     * Author:sjzlai
     * @param $id
     * @return array
     * Date:2018/08/21 9:43
     */
    public static function PartRecordMany($id)
    {
        return self::from('shelf_has_part as shp')
            ->select('shp.*','pi.id as pid','pi.part_name','shelf.id as shelf_id','shelf.shelf_name','shelf.storageroom_id','room.id as room_id','room.store_name')
            ->join('part_info as pi' , 'shp.part_id','=','pi.id')
            ->join('shelf_info as shelf','shelf.id','=','shp.shelf_id')
            ->join('storageroom_info as room','shelf.storageroom_id','=','room.id')
            ->where('shp.id','=',$id)
            ->get()->toArray();
    }
    /**
     * Notes:根据传递的id查询其库存数量
     * Author:sjzlai
     * Date:2018/08/08 11:02
     */
    public static function fistInfo($id)
    {
        return self::where('id','=',$id)->first();
    }
}
