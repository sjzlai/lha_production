<?php

namespace App\Http\Controllers\Admin;

use App\Model\StorageRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StorageRoomController extends Controller
{
    public $storageRoom;
    public function __construct(StorageRoom $storageRoom)
    {
        $this->storageRoom = $storageRoom;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:所有库房
     * @author: weikai
     * @date: 2018/6/26 14:43
     */
    public function index()
    {
        $storagerooms = StorageRoom::roomAll(5);
       return view('lha.storageroom.storageroom-list',['storagerooms'=>$storagerooms]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:模糊搜索
     * @author: weikai
     * @date: 2018/6/26 14:43
     */
    public function fuzzySearch(Request $request)
    {
        $storageRooms = StorageRoom::storageRoomFuzzySearch('store_name',$request->input('keyword'),'5');
        return view('lha.storageroom.storageroom-list',['storagerooms'=>$storageRooms]);
    }

    /**
     * @name:添加库房视图
     * @author: weikai
     * @date: 2018/6/26 14:44
     */
    public function create()
    {
        return view('lha.storageroom.storageroom-add');
    }

    /**
     * @param Request $request
     * @name:执行添加操作
     * @author: weikai
     * @date: 2018/6/26 14:46
     */
    public function store(Request $request)
    {
        $input = trim($request->input('storage_name'));
        if (empty($input)) return withInfoErr('请填写库房名称');
       $this->storageRoom->store_name = $input;
       $res = $this->storageRoom->save();
        if (empty($res)) return withInfoErr('添加失败');
        return redirect('/ad/storageRoom');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param $id
     * @name:修改页面视图
     * @author: weikai
     * @date: 2018/6/26 15:01
     */
    public function edit($id)
    {
        $storageRoom = $this->storageRoom->find($id);
        return view('lha.storageroom.storageroom-edit',['storageroom'=>$storageRoom]);
    }

    /**
     * @param Request $request
     * @param $id
     * @name:执行修改操作
     * @author: weikai
     * @date: 2018/6/26 15:07
     */
    public function update(Request $request, $id)
    {
        $input = trim($request->input('store_name'));
        if (empty($id)) return jsonReturn('0','没有用户id');
        if (empty($input)) return jsonReturn('0','没有输入库房名');
        $storageRoom = $this->storageRoom->find($id);
        $storageRoom->store_name = $input;
        $res = $storageRoom->save();
        if(!$res) return jsonReturn('0','修改失败');
        return jsonReturn('1','修改成功');
    }

    /**
     * @param $id
     * @name:删除库房
     * @author: weikai
     * @date: 2018/6/26 15:17
     */
    public function destroy($id)
    {
        if (!$id) return jsonReturn('0','没有仓库id');
        $res = StorageRoom::destroy($id);
        if (!$res) return jsonReturn('0','删除失败');
        return jsonReturn('1','删除成功');
    }
}
