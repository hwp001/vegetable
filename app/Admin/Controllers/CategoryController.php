<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryController extends Controller
{
    use ModelForm;

    protected $header = '商品种类管理列表';
    protected $description = [
        'index'  => '首页',
        'show'   => '展示',
        'edit'   => '编辑',
        'create' => '创建',
    ];
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header($this->header);
            $content->description('商品种类');
            $content->row( function (Row $row){
                $row->column(6, $this->treeView()->render());
                $row->column(6, function (Column $column){
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_base_path('goods/category'));
                    $form->text('name','类型名称');
                    $form->textarea('description','类型描述信息');
                    $form->select('pid','父类名称')->options(Category::selectOptions());
                    $form->hidden('_token')->default(csrf_token());
                    $column->append((new Box(trans('admin.new'), $form))->style('success'));
                });
            });
        });
    }

    protected function treeView()
    {
        return Category::tree(function (Tree $tree){
            $tree->disableCreate();
            return $tree;
        });
    }

    /**
     * @param $id
     * @return Content
     * 编辑页
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id){
            $content->header($this->header);
            $content->description('编辑类型');
            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content){
            $content->header($this->header);
            $content->description('添加类型');
            $content->body($this->form);
        });
    }

    public function form()
    {
        return Admin::form(Category::class, function(Form $form){
            $form->display('id', '编号');
            $form->text('name','类型名称');
            $form->textarea('description','描述');
            $form->select('pid', '父类名称')->options(Category::selectOptions());
        });
    }

    public function getCategoryOptionis()
    {
        return DB::table('bs_goods_category')->select('id', 'name as text')->get();
    }

}
