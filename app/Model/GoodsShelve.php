<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class GoodsShelve
 * @package App\Model
 * @name:货架模型
 * @author: weikai
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
     * @author: weikai
     * @date: 2018/6/26 16:07
     */
    public function goodsShelveAll($storageRoomId,$page=5)
    {
       return self::where('storageroom_id',$storageRoomId)->orderBy('created_at','desc')->paginate($page);
    }
}
