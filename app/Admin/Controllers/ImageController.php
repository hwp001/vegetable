<?php

namespace App\Admin\Controllers;

use App\Models\Image;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ImageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '图片列表';

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
        $grid = new Grid(new Image());

        $grid->column('id', __('图片编号'));
        $grid->column('imgUrl', __('图片地址'))->image(config('app.url')."/upload",50,50);
        $grid->column('description', __('图片描述'));
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
        $show = new Show(Image::findOrFail($id));

        $show->field('id', __('编号'));
        $show->field('imgUrl', __('图片地址'));
        $show->field('description', __('描述'));
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
        $form = new Form(new Image());
        $form->image('imgUrl', __('图片地址'))->move('/goodImg');
        $form->text('description', __('图片描述'))->default('暂无描述');
        $form->switch('state', __('状态'));
        return $form;
    }
}
