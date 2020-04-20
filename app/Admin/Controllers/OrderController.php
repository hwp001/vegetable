<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单列表';

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
        $grid = new Grid(new Order());

        $grid->column('id', __('编号'));
        $grid->column('cid', __('客户编号'));
        $grid->column('gid', __('商品编号'));
        $grid->column('cargo_id', __('收获地址编号'));
        $grid->column('count', __('数量（件）'));
        $grid->column('gain_way_bool', __('获得方式'));
        $grid->column('pay_way_bool', __('支付方式'));
        $grid->column('have_way_bool', __('获得方法'));
        $grid->column('time', __('下单时间'));
        $grid->column('true_order', __('订单签收状态'));
        $grid->column('state', __('订单状态'));
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
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('编号'));
        $show->field('cid', __('客户编号'));
        $show->field('cargo_id', __('收获地址编号'));
        $show->field('gain_way_bool', __('获得方式'));
        $show->field('pay_way_bool', __('支付方式'));
        $show->field('have_way_bool', __('获得方法'));
        $show->field('time', __('下单时间'));
        $show->field('true_order', __('订单签收状态'));
        $show->field('state', __('订单状态'));
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
        $form = new Form(new Order());

        $form->number('cid', __('客户编号'));
        $form->number('gid', __('商品编号'));
        $form->number('cargo_id', __('收获地址编号'));
        $form->number('count', __('数量（件）'));
        $form->switch('gain_way_bool', __('获得方式'));
        $form->switch('pay_way_bool', __('支付方式'));
        $form->switch('have_way_bool', __('获得方法'));
        $form->text('time', __('下单时间'));
        $form->switch('true_order', __('订单签收状态'));
        $form->switch('state', __('订单状态'));

        return $form;
    }
}
