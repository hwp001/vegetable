<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ModelTree, AdminBuilder;
    //关联表
    protected $table = 'bs_goods_category';
    //不可批量存入
    protected $guarded = [];
    //修改字段名称
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setParentColumn('pid');
        $this->setOrderColumn('sort');
        $this->setTitleColumn('name');
    }

}
