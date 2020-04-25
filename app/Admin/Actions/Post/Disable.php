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
