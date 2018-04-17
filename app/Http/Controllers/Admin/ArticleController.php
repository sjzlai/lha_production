<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    public function articleList(){
        return view('sjzlai.article.article-list');
    }

    public function add(){
        return view('sjzlai.article.add');
    }

    public function articleAdd(Request $request){
        $data = $request->all();
        dd($data);
        //return $data;
    }
}
