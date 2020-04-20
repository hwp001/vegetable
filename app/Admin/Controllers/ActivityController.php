<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\Goods;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品活动表';

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
        $grid = new Grid(new Activity());

        $grid->column('id', __('编号'));
        $grid->column('gid', __('商品ID'));
        $grid->column('count', __('数量(件)'));
        $grid->column('discount', __('折扣'));
        $grid->column('start_time', __('开始时间'));
        $grid->column('end_time', __('结束时间'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更改时间'));

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
        $show = new Show(Activity::findOrFail($id));

        $show->field('id', __('编号'));
        $show->field('gid', __('商品编号'));
        $show->field('count', __('数量（件）'));
        $show->field('start_time', __('开始时间'));
        $show->field('end_time', __('结束时间'));
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
        $form = new Form(new Activity());
        $form->select('gid', __('商品名'))->options('/admin/getGoodsIdAndName');
        $form->number('count', __('数量（件）'));
        $form->number('discount',__('折扣'));
        $form->datetime('start_time', __('开始时间'));
        $form->datetime('end_time', __('结束时间'));
        return $form;
    }
}
