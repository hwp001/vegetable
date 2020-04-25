<?php

namespace App\Admin\Actions\Post;

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
        $saying = '拉黑中';
        if ($bool) {
            $saying = '拉黑成功';
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
