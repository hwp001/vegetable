<?php

namespace App\Admin\Controllers;

use App\Models\Mp;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Client;

class MpController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Mp';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Mp());
        $grid->column('id', __('Id'));
        $grid->column('cid', __('Cid'));
        $grid->column('client.name', _('用户名'));
        $grid->column('mp_openid', __('Mp openid'));
        $grid->column('wx_openid', __('Wx openid'));
        $grid->column('unionid', __('Unionid'));
        $grid->column('state', __('State'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Mp::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('mp_openid', __('Mp openid'));
        $show->field('wx_openid', __('Wx openid'));
        $show->field('unionid', __('Unionid'));
        $show->field('state', __('State'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Mp());

        $form->number('cid', __('Cid'));
        $form->text('mp_openid', __('Mp openid'));
        $form->text('wx_openid', __('Wx openid'));
        $form->text('unionid', __('Unionid'));
        $form->switch('state', __('State'));

        return $form;
    }
}
