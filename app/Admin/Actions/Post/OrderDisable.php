<?php

namespace App\Admin\Actions\Post;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use App\Models\Order;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class OrderDisable extends RowAction
{
    public $name = '拉黑';

    public function handle(Model $model)
    {
        //获得订单id
        $id = $model->id;
        $bool = (new Order())->changeStateById($id,2);
        $saying = '拉黑中';
        if ($bool) {
            $saying = '拉黑成功';
            //根据订单id获取评论用户邮箱
            $email = ToolController::getEmailById($id,'bs_orders');
            if (!empty($email)){
                //发送邮箱给用户
                ToolController::sendEmail($email,'您的订单不合格');
            }
        } else {
            $saying = '拉黑失败';
        }
        return $this->response()->success($saying)->refresh();
    }
    public function dialog()
    {
        $this->confirm('确定拉黑该订单');
    }

}
