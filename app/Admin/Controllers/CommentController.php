<?php

namespace App\Admin\Controllers;

use App\Models\Client;
use App\Models\Comment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Goods;
use Request;

class CommentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '评论列表';

    protected $description = [
        'index'  => '首页',
        'show'   => '展示',
        'edit'   => '编辑',
        'create' => '创建',
    ];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment());

        $grid->column('id', __('编号'));
        $grid->column('cid', __('客户编号'));
        $grid->column('gid', __('商品编号'));
        $grid->column('star', __('评分'));
        $grid->column('description', __('评论'));
        $grid->column('imgUrl', __('图片编号'));
        $grid->column('state', __('状态'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', __('编号'));
        $show->field('cid', __('客户编号'));
        $show->field('gid', __('商品编号'));
        $show->field('star', __('评分'));
        $show->field('description', __('评论'));
        $show->field('imgUrl', __('图片编号'));
        $show->field('state', __('状态'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Comment());
        $form->select('cid', __('客户编号'))->options('/admin/getClientsIdAndUsername');
        $form->select('gid', __('商品编号'))->options('/admin/getGoodsIdAndName')->load('imgUrl','/admin/getImg');
        $form->select('imgUrl',__('图片编号'))->value('text');
        $form->number('star', __('评分级别'))->default(5)->rules('min:1|max:5');
        $form->text('description', __('评论'))->default('暂无描述');
//        $form->image('imgUrl', __('商品图片'))->move('/goodImg');

        $form->switch('state', __('状态'));
        return $form;
    }



    //根据商品ID 获得图片ID
    public function getImg(Request $request)
    {
        $id = $request::input('q');
        $res =  Goods::where('id',$id)->get(['id','img_ids as text']);
        $pattem = '/\"(.*)\"/';
        preg_match($pattem,$res[0]['text'],$match);
        $res[0]['text'] = $match[1];
        return $res;
    }

}
