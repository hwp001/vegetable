<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cargo extends Model
{
    protected $table = 'bs_cargo';
    protected $guarded = [];
    protected function getSexAttribute($value){
        if ($value == 0){
            return '女';
        } else {
            return '男';
        }
    }
    protected function setSexAttribute($value){
        if ($value == '女'){
            $this->attributes['sex'] = 0;
        } else {
            $this->attributes['sex'] = 1;
        }
    }

    //添加收货地址
    public function addCargo($data)
    {
        //将 sort: 0=>false 1=>true
        $data['sort'] = ($data['sort'] == 'true')? 1:0;
        //根据openid 找到cid
       $res = DB::table('bs_mps')
            ->leftJoin('bs_clients','bs_clients.id','bs_mps.cid')
            ->where('bs_mps.wx_openid',$data['openId'])
            ->get('bs_mps.cid');
        if (!empty($res)){
            $cid = $res[0]->cid;

            //构建地址数据
            $cargo_data = [
                'cid'  => $cid,
                'name' => $data['name'],
                'address' => $data['address'],
                'sex' => intval($data['sex']),
                'phone' => $data['phone'],
                'sort' => $data['sort']
            ];
            //新增地址并且拿取id
            $id = Cargo::create($cargo_data)->id;
            if (!empty($id)){
                //设定默认 若自身为true 则设定其他true为false
                if ($data['sort'] == 1) {
                   $res = Cargo::where('id','!=',$id)
                        ->where('sort', 1)
                        ->update(['sort'=> 0]);
                   if (!empty($res)){
                       return true;
                   } else {
                       return false;
                   }
                }
                return true;
            } else {
                //新增地址失败
                return false;
            }
        }
    }

    //获取该openid 所有快递地址
    public function getCargo($data)
    {
        $res = DB::table('bs_mps')
            ->leftJoin('bs_clients','bs_clients.id','bs_mps.cid')
            ->where('bs_mps.wx_openid',$data['openId'])
            ->get('bs_mps.cid');
        if (!empty($res)) {
            $cid = $res[0]->cid;
            $cargo = Cargo::where('cid',$cid)
                ->orderBy('sort','desc')
                ->get(['id','name','phone','address','sex','sort']);
            if (!empty($cargo)) {
                return $cargo;
            } else {
                //暂无数据
                return false;
            }
        }
    }

    //根据id 更新快递地址 是否默认
    public function updateCargo($data)
    {
        $res = Cargo::where('id',$data['id'])->update(['sort'=>1]);
        if (!empty($res)) {
            //更新不是本id为false
            $row = Cargo::where('id','!=',$data['id'])->update(['sort'=>0]);
            return true;
        } else {
            return false;
        }
    }

    //根据id 获取快递地址
    public function getCargoById($data)
    {
        return Cargo::where('id',intval($data['id']))->get(['id','cid','name','phone','address','sex','sort']);
    }

    //根据id 更新快递地址
    public function updateCargoById($data)
    {
        //转换 sort
        $data['sort'] = ($data['sort'] == 'true')? 1:0;
        $update_data = [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'sex' => $data['sex'],
            'sort' => $data['sort']
        ];
        //根据id 更新快递地址
        $row = Cargo::where('id',$data['id'])->update($update_data);
        if (!empty($row)){
            //若是 sort 为 true 则除去其他 true 只保留一个默认
            if ($data['sort'] == 1) {
                //更新了就行 不用管影响行数
                 Cargo::where('id','!=',$data['id'])->update(['sort'=>0]);
                 return true;
            }
        } else {
            return false;
        }

    }

    //根据id 删除快递地址
    public function delCargoById($data)
    {
       $row = Cargo::where('id',$data['id'])->delete();
       if (!empty($row)){
           return true;
       }
       return false;
    }

    //根据id 查看 快递是否 已被使用
    public function hashId($data)
    {
        $res = Order::where('cargo_id',$data['id'])->get();
        if (count($res) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
