<?php

namespace App\Admin\Controllers;

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
    protected $title = 'App\Models\Cargo';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Cargo());

        $grid->column('id', __('Id'));
        $grid->column('cid', __('Cid'));
        $grid->column('name', __('Name'));
        $grid->column('phone', __('Phone'));
        $grid->column('address', __('Address'));
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
        $show = new Show(Cargo::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('name', __('Name'));
        $show->field('phone', __('Phone'));
        $show->field('address', __('Address'));
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
        $form = new Form(new Cargo());

        $form->number('cid', __('Cid'));
        $form->text('name', __('Name'));
        $form->mobile('phone', __('Phone'));
        $form->text('address', __('Address'));
        $form->switch('state', __('State'));

        return $form;
    }
}
