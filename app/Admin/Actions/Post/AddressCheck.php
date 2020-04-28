<?php

namespace App\Admin\Actions\Post;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use App\Models\Comment;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class AddressCheck extends RowAction
{
    public $name = '审核';

    public function handle(Model $model)
    {
        //获取评论id
        $id = $model->id;
        $bool = (new Cargo())->changeStateById($id,1);
        $saying = '审核中';
        if ($bool) {
            $saying = '审核成功';
            //根据评论id获取评论用户邮箱
            $email = ToolController::getEmailById($id,'bs_cargo');
            if (!empty($email)){
                //发送邮箱给用户
                ToolController::sendEmail($email,'收货地址审核成功');
            }
        } else {
            $saying = '审核失败';
        }

        return $this->response()->success($saying)->refresh();
    }

    public function dialog()
    {
        $this->confirm('确定审核该收货地址？');
    }
}
