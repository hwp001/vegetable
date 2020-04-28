<?php

namespace App\Admin\Actions\Post;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class AddressDisable extends RowAction
{
    public $name = '拉黑';

    public function handle(Model $model)
    {
        //获取评论id
        $id = $model->id;
        $bool = (new Cargo())->changeStateById($id,1);
        $saying = '禁用中';
        if ($bool) {
            $saying = '禁用成功';
            //根据评论id获取评论用户邮箱
            $email = ToolController::getEmailById($id,'bs_cargo');
            if (!empty($email)){
                //发送邮箱给用户
                ToolController::sendEmail($email,'收货地址已被禁用');
            }
        } else {
            $saying = '禁用失败';
        }

        return $this->response()->success($saying)->refresh();
    }

    public function dialog()
    {
        $this->confirm('确定禁用该收货地址？');
    }

}
