<?php

namespace App\Admin\Actions\Post;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use App\Models\Order;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class OrderCheck extends RowAction
{
    public $name = '确认';

    public function handle(Model $model)
    {
        //获得订单id
        $id = $model->id;
        $bool = (new Order())->changeStateById($id,1);
        $saying = '确认中';
        if ($bool) {
            $saying = '确认成功';
            //根据订单id获取评论用户邮箱
            $email = ToolController::getEmailById($id,'bs_orders');
            if (!empty($email)){
                //发送邮箱给用户
                ToolController::sendEmail($email,'您的订单正在确认中');
            }
        } else {
            $saying = '确认失败';
        }
        return $this->response()->success($saying)->refresh();
    }
    public function dialog()
    {
        $this->confirm('确认订单');
    }
}
