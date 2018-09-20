<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShelfInfo
 * @package App\Model
 * @name:货架模型
 * @author: 
 * @date: 2018/7/13 10:08
 */
class ShelfInfo extends Model
{
    protected $table = 'shelf_info';
    public $timestamps = true;
    protected $guarded = [];

    /**
     * @param $storageRoomId
     * @return \Illuminate\Support\Collection
     * @name:通过库房id查找所有货架
     * @author: 
     * @date: 2018/7/13 10:21
     */
    public static function shelfInfo($storageRoomId)
    {
        return self::where('storageroom_id',$storageRoomId)->get();//货架信息
    }
}
