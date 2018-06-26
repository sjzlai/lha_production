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
}
