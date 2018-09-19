<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class GoodsShelve
 * @package App\Model
 * @name:货架模型
 * @author: 
 * @date: 2018/6/26 15:47
 */
class GoodsShelve extends Model
{
    protected $table = 'shelf_info';
    protected $guarded = [];

    /**
     * @param $storageRoomId
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @name:库房下所有货架列表
     * @author: 
     * @date: 2018/6/26 16:07
     */
    public static function goodsShelveAll($storageRoomId,$page=5)
    {
       return self::where('storageroom_id',$storageRoomId)->orderBy('created_at','desc')->paginate($page);
    }

    /**
     * @name:货架模糊搜索
     * @author: 
     * @date: 2018/6/28 9:30
     */
    public static function goodsShelveFuzzySearch($storageRoomId,$key,$keyword,$page=5)
    {
       return self::where('storageroom_id',$storageRoomId)
           ->where($key,'like','%'.$keyword.'%')
           ->orderBy('created_at','desc')
           ->paginate($page);
    }

    /**
     * @param $goodsShelve
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @name:货架下所有物品信息
     * @author: 
     * @date: 2018/6/27 9:54
     */
    public static function goodsList($goodsShelve)
    {
        return self::from('shelf_has_part as shp')
        ->where('shelf_id',$goodsShelve)
        ->leftJoin('part_info as pi','shp.part_id','=','pi.id')
            ->Where('shp.part_number','<>',0)
        ->orderBy('shp.created_at','desc')
        ->paginate(15);
    }

    /**
     * @param $key
     * @param $keyword
     * @param $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @name:模糊搜索物品
     * @author: 
     * @date: 2018/6/27 15:00
     */
    public static function goodsFuzzySearch($goodsShelve,$keyword,$page=5)
    {

        return self::from('shelf_has_part as sp')
            ->where('sp.shelf_id',$goodsShelve)
            ->where('p.part_name','like','%'.$keyword.'%')
            ->select('sp.*','p.part_name')
            ->leftJoin('part_info as p','sp.part_id','=','p.id')
            ->orderBy('sp.created_at','desc')
            ->paginate($page);
    }


    public static function RoomShelveList($id)
    {
        return self::where('storageroom_id','=',$id)->get();
    }
}
