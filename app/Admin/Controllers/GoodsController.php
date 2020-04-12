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
    protected $title = 'App\Models\Goods';

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
        $grid->column('kind_id', __('种类ID'));
        $grid->column('img_ids', __('图片ID'));
        $grid->column('price', __('价格（元）'));
        $grid->column('count', __('总重量(斤)'));
        $grid->column('cavr', __('收藏量'));
        $grid->column('buy_state', __('出售方式'));
        $grid->column('state', __('状态'));
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
        $show = new Show(Goods::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('kind_id', __('Kind id'));
        $show->field('img_ids', __('Img ids'));
        $show->field('price', __('Price'));
        $show->field('count', __('Count'));
        $show->field('cavr', __('Cavr'));
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
        $form = new Form(new Goods());

        $form->text('title', __('Title'))->creationRules(['required','unique:bs_goods']);
        $form->text('description', __('Description'))->default('暂无描述');
//        $form->number('kind_id', __('Kind id'));
        $form->select('kind_id','商品种类')->options(
            Category::selectOptions()
        );
//        $form->text('img_ids', __('Img ids'));
        $form->multipleImage('img_ids','配图')->move('/goodImg');
        $form->number('price', __('Price'));
        $form->number('count', __('Count'));
        $form->number('cavr', __('Cavr'));
        $form->switch('buy_state', __('出售方式'));
        $form->switch('state', __('State'));
        return $form;
    }

    //获取全部商品 id name
    public function getGoodsIdAndName()
    {
        return Goods::all(['id','title as text']);
    }

}

