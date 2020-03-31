<?php

namespace App\Admin\Controllers;

use App\Models\Client;
use App\Models\Comment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Goods;
use Request;

class CommentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Comment';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment());

        $grid->column('id', __('Id'));
        $grid->column('cid', __('Cid'));
        $grid->column('gid', __('Gid'));
        $grid->column('star', __('Star'));
        $grid->column('description', __('Description'));
        $grid->column('imgUrl', __('ImgUrl'));
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
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('gid', __('Gid'));
        $show->field('star', __('Star'));
        $show->field('description', __('Description'));
        $show->field('imgUrl', __('ImgUrl'));
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
        $form = new Form(new Comment());
        $form->select('cid', __('评论用户'))->options('/admin/getClientsIdAndUsername');
        $form->select('gid', __('评论商品'))->options('/admin/getGoodsIdAndName')->load('imgUrl','/admin/getImg');
        $form->select('imgUrl',__('图片ID'))->value('text');
        $form->number('star', __('评分级别'))->default(5)->rules('min:1|max:5');
        $form->text('description', __('评论描述'))->default('暂无描述');
//        $form->image('imgUrl', __('商品图片'))->move('/goodImg');

        $form->switch('state', __('状态'));
        return $form;
    }



    //根据商品ID 获得图片ID
    public function getImg(Request $request)
    {
        $id = $request::input('q');
        $res =  Goods::where('id',$id)->get(['id','img_ids as text']);
        $pattem = '/\"(.*)\"/';
        preg_match($pattem,$res[0]['text'],$match);
        $res[0]['text'] = $match[1];
        return $res;
    }

}
