<?php

namespace App\Admin\Controllers;

use App\Models\Client;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ClientController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '客户详情表';
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
        $grid = new Grid(new Client());

        $grid->column('id', __('编号'));
        $grid->column('username', __('用户名'));
        $grid->column('name', __('姓名'));
        $grid->column('avatar', __('头像'))->image(config('app.url').'/upload',50,50);
        $grid->column('phone', __('电话号码'));
        $grid->column('email', __('邮箱'));
        $grid->column('ip', __('IP地址'));
        $grid->column('address', __('所在地区'));
        $grid->column('login_times', __('登录次数'));
        $grid->column('decs', __('个性签名'));
        $grid->column('state', __('状态'))->display(function($state) {
            switch ($state) {
                case 0 : $state = '正常';break;
                case 1 : $state = '拉黑';break;
            }
            return $state;
        });
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
        $show = new Show(Client::findOrFail($id));

        $show->field('id', __('编号'));
        $show->field('username', __('用户名'));
        $show->field('name', __('姓名'));
        $show->field('avatar', __('头像'))->avatar(config('api.url').'/upload')->image();
        $show->field('phone', __('手机号'));
        $show->field('email', __('邮箱'));
        $show->field('ip', __('IP地址'));
        $show->field('address', __('所在地区'));
        $show->field('login_times', __('登录次数'));
        $show->field('decs', __('个性签名'));
        $show->field('state', __('状态'))->as(function ($state) {
            switch ($state) {
                case 0 : $state = '正常';break;
                case 1 : $state = '拉黑';break;
            }
            return $state;
        });
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
        $form = new Form(new Client());

        $form->text('username', __('用户名'));
        $form->text('name', __('真实姓名'));
        $form->image('avatar', __('头像'));
        $form->mobile('phone', __('手机号码'));
        $form->email('email', __('邮箱'));
        $form->ip('ip', __('IP地址'));
        $form->text('address', __('所在地区'));
        $form->number('login_times', __('登录次数'));
        $form->text('decs', __('个性签名'));
        $form->switch('state', __('状态'));

        return $form;
    }

    //获得全部用户 id username
    public function getClientsIdAndUsername()
    {
        return Client::all(['id','username as text']);
    }
}
