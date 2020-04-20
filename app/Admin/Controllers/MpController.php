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
    protected $title = '公众号管理';

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
        $grid = new Grid(new Mp());
        $grid->column('id', __('编号'));
        $grid->column('cid', __('客户编号'));
        $grid->column('client.name', _('真实姓名'));
        $grid->column('mp_openid', __('公众号openId'));
        $grid->column('wx_openid', __('小程序openId'));
        $grid->column('unionid', __('公众号平台UnionId'));
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
        $show = new Show(Mp::findOrFail($id));

        $show->field('id', __('编号'));
        $show->field('cid', __('客户编号'));
        $show->field('mp_openid', __('公众号openId'));
        $show->field('wx_openid', __('小程序openId'));
        $show->field('unionid', __('公众号平台UnionId'));
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
        $form = new Form(new Mp());

        $form->number('cid', __('客户编号'));
        $form->text('mp_openid', __('公众号编号'));
        $form->text('wx_openid', __('小程序编号'));
        $form->text('unionid', __('微信公众平台UnionId'));
        $form->switch('state', __('状态'));

        return $form;
    }
}
