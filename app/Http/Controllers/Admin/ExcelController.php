<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;

/**
 * Class ExcelController
 * @package App\Http\Controllers\Admin
 * @name:Excel控制器
 * @author: weikai
 * @date: 2018/7/11 15:01
 */
class ExcelController extends Controller
{
    /**
     * @name:excel导出
     * @author: weikai
     * @date: 2018/7/11 15:01
     */
    public function export($title,$cellData)
    {

        Excel::create($title,function($excel) use ($cellData){
            $excel->sheet('title', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
}
