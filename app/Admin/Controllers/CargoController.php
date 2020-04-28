<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\AddressCheck;
use App\Admin\Actions\Post\AddressDisable;
use App\Models\Cargo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CargoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '收获地址';
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
        $grid = new Grid(new Cargo());

        $grid->column('id', __('编号'));
        $grid->column('cid', __('客户编号'));
        $grid->column('name', __('收货姓名'));
        $grid->column('phone', __('收货号码'));
        $grid->column('address', __('收货地址'));
        $grid->column('state', __('状态'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        $grid->actions(function($actions){
            $actions->add(new AddressCheck);
            $actions->add(new AddressDisable);
        });

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
        $show = new Show(Cargo::findOrFail($id));

        $show->field('id', __('编号'));
        $show->field('cid', __('客户编号'));
        $show->field('name', __('收货人'));
        $show->field('phone', __('收货号码'));
        $show->field('address', __('收货地址'));
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
        $form = new Form(new Cargo());

        $form->number('cid', __('客户编号'));
        $form->text('name', __('收货人'));
        $form->mobile('phone', __('收货号码'));
        $form->text('address', __('收获地址'));
        $form->switch('state', __('状态'));

        return $form;
    }
}
