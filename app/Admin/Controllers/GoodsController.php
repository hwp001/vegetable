<?php

namespace App\Admin\Controllers;

use App\Models\Goods;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Category;
use http\Env\Request;
use Illuminate\Support\Facades\Log;

class GoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品列表';
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
        $grid = new Grid(new Goods());

        $grid->column('id', __('编号'));
        $grid->column('title', __('商品名'));
        $grid->column('description', __('商品描述'));
        $grid->column('kind_id', __('种类编号'));
        $grid->column('img_ids', __('图片编号'));
        $grid->column('price', __('价格（元）'));
        $grid->column('count', __('数量(件)'));
        $grid->column('cfav', __('收藏量'));
        $grid->column('buy_state', __('出售方式'));
        $grid->column('state', __('状态'))->display(function($state) {
            switch ($state) {
                case 0 : $state = '正常';break;
                case 2 : $state = '禁用';break;
            }
            return $state;
        })->label([
            0=>'success',
            2=>'danger'
        ]);
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
        $show = new Show(Goods::findOrFail($id));

        $show->field('id', __('编号'));
        $show->field('title', __('商品名'));
        $show->field('description', __('描述'));
        $show->field('kind_id', __('种类编号'));
        $show->field('img_ids', __('图片编号'));
        $show->field('price', __('价格（元）'));
        $show->field('count', __('数量（件）'));
        $show->field('cfav', __('收藏量'));
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
        $form = new Form(new Goods());

        $form->text('title', __('商品名'))->creationRules(['required','unique:bs_goods']);
        $form->text('description', __('描述'))->default('暂无描述');
//        $form->number('kind_id', __('Kind id'));
        $form->select('kind_id','商品种类')->options(
            Category::selectOptions()
        );
//        $form->text('img_ids', __('Img ids'));
        $form->multipleImage('img_ids','选择图片')->move('/goodImg');
        $form->number('price', __('价格（元）'));
        $form->number('count', __('数量（件）'));
        $form->number('cfav', __('收藏量'));
        $form->switch('buy_state', __('出售方式'));
        $form->switch('state', __('状态'));
        return $form;
    }

    //获取全部商品 id name
    public function getGoodsIdAndName()
    {
        return Goods::all(['id','title as text']);
    }

}

