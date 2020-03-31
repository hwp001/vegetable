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
    protected $title = '客户详情';
    protected $description = [
        'index' => '显示'
    ];

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Client());

        $grid->column('id', __('Id'));
        $grid->column('username', __('用户名'));
        $grid->column('name', __('姓名'));
        $grid->column('avatar', __('头像'))->image(config('app.url').'/upload',50,50);
        $grid->column('phone', __('电话号码'));
        $grid->column('email', __('邮箱'));
        $grid->column('ip', __('Ip地址'));
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

        $show->field('id', __('Id'));
        $show->field('username', __('Username'));
        $show->field('name', __('Name'));
        $show->field('avatar', __('Avatar'))->avatar(config('api.url').'/upload')->image();
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));
        $show->field('ip', __('Ip'));
        $show->field('address', __('Address'));
        $show->field('login_times', __('Login times'));
        $show->field('decs', __('Decs'));
        $show->field('state', __('State'))->as(function ($state) {
            switch ($state) {
                case 0 : $state = '正常';break;
                case 1 : $state = '拉黑';break;
            }
            return $state;
        });
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
        $form = new Form(new Client());

        $form->text('username', __('Username'));
        $form->text('name', __('Name'));
        $form->image('avatar', __('Avatar'));
        $form->mobile('phone', __('Phone'));
        $form->email('email', __('Email'));
        $form->ip('ip', __('Ip'));
        $form->text('address', __('Address'));
        $form->number('login_times', __('Login times'));
        $form->text('decs', __('Decs'));
        $form->switch('state', __('State'));

        return $form;
    }

    //获得全部用户 id username
    public function getClientsIdAndUsername()
    {
        return Client::all(['id','username as text']);
    }
}
