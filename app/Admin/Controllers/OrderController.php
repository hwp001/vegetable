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
    protected $title = '订单管理';

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
        $grid->column('cargo_id', __('收货地址编号'));
        $grid->column('gid', __('订单商品id'));
        $grid->column('orderNum', __('订单号'));
        $grid->column('gain_way_bool', __('获得方式'))
            ->display(function ($model){
                switch ($model->gain_way_bool){
                    case 0: return '到店自提';break;
                    case 1: return '快递配送';break;
                }
        });
        $grid->column('pay_way_bool', __('支付方式'))->display(function($model){
            switch ($model->pay_way_bool){
                case 0: return '微信支付';break;
                case 1: return '支付宝支付';break;
                case 2: return '扫码支付';break;
            }
        });
        $grid->column('time', __('下单时间'));
        $grid->column('totalCount', __('总数量'));
        $grid->column('totalPrice', __('总价格'));
        $grid->column('true_order', __('签收状态'))->display(function($model){
            
        });
        $grid->column('state', __('订单状态'));
        $grid->column('created_at', __('创建时间'));
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

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('cargo_id', __('Cargo id'));
        $show->field('gain_way_bool', __('Gain way bool'));
        $show->field('pay_way_bool', __('Pay way bool'));
        $show->field('have_way_bool', __('Have way bool'));
        $show->field('time', __('Time'));
        $show->field('true_order', __('True order'));
        $show->field('state', __('State'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('gid', __('Gid'));
        $show->field('totalCount', __('TotalCount'));
        $show->field('orderNum', __('OrderNum'));
        $show->field('totalPrice', __('TotalPrice'));

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

        $form->number('cid', __('Cid'));
        $form->number('cargo_id', __('Cargo id'));
        $form->switch('gain_way_bool', __('Gain way bool'));
        $form->switch('pay_way_bool', __('Pay way bool'));
        $form->switch('have_way_bool', __('Have way bool'));
        $form->text('time', __('Time'));
        $form->switch('true_order', __('True order'));
        $form->switch('state', __('State'));
        $form->text('gid', __('Gid'));
        $form->number('totalCount', __('TotalCount'));
        $form->text('orderNum', __('OrderNum'));
        $form->number('totalPrice', __('TotalPrice'));

        return $form;
    }
}
