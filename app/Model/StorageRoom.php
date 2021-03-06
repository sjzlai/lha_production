<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StorageRoom
 * @package App\Model
 * @name:库房信息表
 * @author: weikai
 * @date: 2018/6/26 11:30
 */
class StorageRoom extends Model
{
    protected $table = 'storageroom_info';
    public $timestamps = true;
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @name: 查询所有库房
     * @author: weikai
     * @date: 2018/6/22 10:10
     */
    public static function roomAll($page=5)
    {
        return self::orderBy('created_at','desc')->paginate($page);
    }

    /**
     * @param $key
     * @param $keyword
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @name:模糊搜索
     * @author: weikai
     * @date: 2018/6/26 14:38
     */
    public static function storageRoomFuzzySearch($key,$keyword,$page=5)
    {
        return self::where($key,'like',"%$keyword%")->paginate($page);
    }

    /**
     * Notes:查询所有的库房及其关联的货架
     * Author:sjzlai
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * Date:2018/07/03 11:15
     */
    public static function RoomAndShelves()
    {
        return self::from('storageroom_info as room')
            ->select('room.*','room.id as room_id','info.*')
            ->join('shelf_info as info','room.id','=','info.storageroom_id')
            ->get();
    }

    /**
     * @name:查询所有存放成品的货架仓库信息
     */
    public static function productLinkShelf($orderId)
    {

//           return self::from('shelf_has_part as shp')
//            ->where('shp.part_name','=','1')
//            ->where('shp.id','=',$orderId)
//            ->where('shp.part_number','>','0')
//            ->whereNotNull('shp.part_number')
//            ->select('shp.*','si.shelf_name','sri.store_name','shp.shelf_id')
//            ->leftJoin('shelf_info as si','si.id','shp.shelf_id')
//            ->leftJoin('storageroom_info as sri','sri.id','si.storageroom_id')
//            ->orderBy('shp.created_at','desc')
//            ->get();
        return self::from('shelf_has_part as shp')
            ->where('shp.part_name','1')
            ->whereNotNull('shp.part_number')
            ->where('order_no',$orderId)
            ->select('shp.*','si.shelf_name','sri.store_name','shp.shelf_id')
            ->leftJoin('shelf_info as si','si.id','shp.shelf_id')
            ->leftJoin('storageroom_info as sri','sri.id','si.storageroom_id')
            ->orderBy('shp.created_at','desc')
            ->get();
    }
}
