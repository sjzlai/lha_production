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
     * @name:所有库房
     */
    public function index()
    {
        $storagerooms = StorageRoom::roomAll(5);
       return view('lha.storageroom.storageroom-list',['storagerooms'=>$storagerooms]);
    }

    /**
     * @name:模糊搜索
     */
    public function fuzzySearch(Request $request)
    {
        $storageRooms = StorageRoom::storageRoomFuzzySearch('store_name',$request->input('keyword'),'5');
        return view('lha.storageroom.storageroom-list',['storagerooms'=>$storageRooms]);
    }

    /**
     * @name:添加库房视图
     */
    public function create()
    {
        return view('lha.storageroom.storageroom-add');
    }

    /**
     * @name:执行添加操作
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
     */
    public function show($id)
    {
        //
    }

    /**
     * @name:修改页面视图
     */
    public function edit($id)
    {
        $storageRoom = $this->storageRoom->find($id);
        return view('lha.storageroom.storageroom-edit',['storageroom'=>$storageRoom]);
    }

    /**
     * @name:执行修改操作
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
     * @name:删除库房
     */
    public function destroy($id)
    {
        if (!$id) return jsonReturn('0','没有仓库id');
        $res = StorageRoom::destroy($id);
        if (!$res) return jsonReturn('0','删除失败');
        return jsonReturn('1','删除成功');
    }
}
