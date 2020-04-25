<?php

namespace App\Admin\Controllers;

use App\Models\OrdersGood;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrdersGoodController extends AdminController
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
        $grid = new Grid(new OrdersGood());

        $grid->column('id', __('编号'));
        $grid->column('gid', __('商品编号'));
        $grid->column('totalPrice', __('总价格（元）'));
        $grid->column('totalCount', __('总数量'));
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
        $show = new Show(OrdersGood::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('gid', __('Gid'));
        $show->field('totalPrice', __('TotalPrice'));
        $show->field('totalCount', __('TotalCount'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new OrdersGood());

        $form->number('gid', __('Gid'));
        $form->number('totalPrice', __('TotalPrice'));
        $form->number('totalCount', __('TotalCount'));

        return $form;
    }
}
