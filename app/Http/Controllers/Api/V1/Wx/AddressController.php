<?php

namespace App\Http\Controllers\Api\V1\Wx;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //新增地址
    public function addCargo(Request $request)
    {
        $data = $request->all();

        $bool = (new Cargo())->addCargo($data);
        if ($bool) {
            return json_encode(['statu'=>1]);
        } else {
            return json_encode(['statu'=>0,'err'=>'新增失败']);
        }
    }
    //获得地址
    public function getCargo(Request $request)
    {
        $data = $request->all();
        $res = (new Cargo())->getCargo($data);
        if ($res) {
            return json_encode(['statu'=>1,'data'=>$res]);
        } else {
            return json_encode(['statu'=>0,'err'=>'暂无数据']);
        }
    }
    //更新快递地址
    public function updateCargo(Request $request)
    {
        $data = $request->all();
        $bool =  (new Cargo())->updateCargo($data);
        if ($bool){
            return json_encode(['statu'=>1]);
        } else {
            return json_encode(['statu'=>0,'err'=>'更新快递地址失败']);
        }
    }
    //根据id获取快递地址
    public function getCargoById(Request $request)
    {
        $data = $request->all();
        $res = (new Cargo())->getCargoById($data);
        if (!empty($res)){
            return json_encode(['statu'=>1,'cargo'=>$res]);
        } else {
            return json_encode(['statu'=>0]);
        }
    }
    //根据id更新快递地址
    public function updateCargoById(Request $request)
    {
        $data = $request->all();
        $bool = (new Cargo())->updateCargoById($data);
        if ($bool){
            return json_encode(['statu'=>1]);
        } else {
            return json_encode(['statu'=>0,'err'=>'数据并未改变']);
        }
    }
    //根据id删除快递地址
    public function delCargoById(Request $request)
    {
        $data = $request->all();
        $bool = (new Cargo())->delCargoById($data);
        if ($bool){
            return json_encode(['statu'=>1]);
        } else {
            return json_encode(['statu'=>0,'err'=>'删除失败']);
        }
    }
}
