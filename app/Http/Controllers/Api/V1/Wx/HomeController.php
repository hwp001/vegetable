<?php

namespace App\Http\Controllers\Api\V1\Wx;

use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\V1\Wx\ToolController;

class HomeController extends Controller
{
    //返回home界面推荐图  还有 中间图片
    public function home()
    {
        //推荐图
        $imageList = [];
        //中间图
        $recommandList = [];
        $res = Image::all(['ImgUrl','Description']);

        foreach ($res as $k => $v) {
            if ($v['Description'] == 'recommend') {
                $imageList[] = $v;
            }
            if ($v['Description'] != 'recommend' && !empty($v['Description'])) {
                $recommandList[] = $v;
            }
        }

        $title = '';
        for ($i=0; $i< count($recommandList); $i++){
            switch ($recommandList[$i]['Description']){
                case "fruit";  $title = '新鲜水果';break;
                case "frozen"; $title = '冷藏冰冻';break;
                case "vegetable"; $title = '时令蔬菜';break;
                case "meal"; $title = "肉鱼禽蛋";break;
                case "oil"; $title = "粮油调味";break;
                case "clear"; $title = "日用清洁";break;
                case "drink"; $title = "酒水冲饮";break;
                case "make"; $title = "护理美妆";break;
                case "bread"; $title = "牛奶面包";break;
                case "snack"; $title = "休闲零食";break;
            }
            $recommandList[$i]['title'] = $title;
        }

        $data['imageList'] = $imageList;
        $data['recommandList'] = $recommandList;

        return json_encode($data);
    }

    //优惠 推荐
    //1、活动表 优惠  2、收藏人数 推荐
    public function multiData()
    {
        $data = [
            'new' => $this->dataTwo(),
            'pop' => $this->dataOne(50),
            'sell' => $this->dataOne(50),
        ];
        return json_encode($data);
    }
    //根据收藏人数 获取商品数据
    public function dataOne($cfav)
    {
        return (new Goods())->detail('cfav','>',$cfav);
    }
    //获取活动表中的商品数据
    public function dataTwo()
    {
        $res = DB::table('dataTwo')->get();
        return ToolController::IdtoUrl($res);
    }
    //商品搜索
    public function searchGood(Request $request)
    {
        $data = $request->all();
        $goodId = (new Goods())->searchGood($data);
        if (!empty($goodId)) {
            return json_encode(['statu'=>1,'data'=>$goodId]);
        } else {
            return json_encode(['statu'=>0,'err'=>'请重新输入关键字']);
        }
    }
}
