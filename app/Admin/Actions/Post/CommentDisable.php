<?php

namespace App\Admin\Actions\Post;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use App\Models\Comment;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class CommentDisable extends RowAction
{
    public $name = '拉黑';

    public function handle(Model $model)
    {
        //获取用户id
        $id = $model->id;
        $bool = (new Comment())->changeStateById($id,2);
        $saying = '拉黑中';
        if ($bool) {
            $saying = '拉黑成功';
            $email = ToolController::getEmailById($id,'bs_comment');
            if (!empty($email)){
                //发送邮箱给用户
                ToolController::sendEmail($email,'您的商品评论已被禁用');
            }
        } else {
            $saying = '拉黑失败';
        }

        return $this->response()->success($saying)->refresh();
    }

    public function dialog()
    {
        $this->confirm('确定拉黑该评论？');
    }

}
