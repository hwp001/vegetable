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
    protected $title = 'App\Models\Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->column('id', __('Id'));
        $grid->column('cid', __('Cid'));
        $grid->column('cargo_id', __('Cargo id'));
        $grid->column('gain_way_bool', __('Gain way bool'));
        $grid->column('pay_way_bool', __('Pay way bool'));
        $grid->column('have_way_bool', __('Have way bool'));
        $grid->column('time', __('Time'));
        $grid->column('true_order', __('True order'));
        $grid->column('state', __('State'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));

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

        return $form;
    }
}
