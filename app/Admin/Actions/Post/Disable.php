<?php

namespace App\Admin\Actions\Post;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use App\Http\Controllers\Utils\Tool;
use App\Models\Client;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Disable extends RowAction
{
    public $name = '拉黑';

    public function handle(Model $model)
    {
        //获取用户id
        $id = $model->id;
        $bool = (new Client())->changeStateById($id,2);
        if ($bool) {
            $saying = '拉黑成功';
            //获取用户邮箱
            $email = $model->email;
            $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
            //正则验证邮箱
            preg_match($pattern, $email, $matches);
            if (count($matches) > 0) {
                $email = $matches[1];
            } else {
                $email = 'hwpoo1@163.com';
            }
            ToolController::sendEmail($email,'您已被拉黑');
        } else {
            $saying = '拉黑失败';
        }
        return $this->response()->success($saying)->refresh();
    }

    public function dialog()
    {
        $this->confirm('确定拉黑该用户？');
    }
}
