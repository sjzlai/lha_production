<?php
/**
 * @name 公共函数库
 * @author weikai
 * @date 2018/6/22 11:17
 */

/**
 * @param $name
 * @param $msg
 * @return \Illuminate\Http\RedirectResponse
 * @name:返回给视图错误消息 消息名：error
 * @author: weikai
 * @date: 2018/6/22 11:19
 */
function withInfoErr($msg){
    return back()->with('error',$msg);
}

/**
 * @param $msg
 * @return \Illuminate\Http\RedirectResponse
 * @name:返回给视图提示消息 消息名：message
 * @author: weikai
 * @date: 2018/6/22 11:21
 */
function withInfoMsg($msg){
    return back()->with('message',$msg);
}