<?php

namespace app\admin\controller\cms;

use app\common\controller\Backend;

/**
 * 静态区域
 */
class Block extends Backend
{
    /**
     * Block模型对象
     * @var object
     * @phpstan-var \app\admin\model\cms\Block
     */
    protected object $model;

    protected string|array $quickSearchField = ['编号'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\cms\Block();
    }


    /**
     * 若需重写查看、编辑、删除等方法，请复制 @see \app\admin\library\traits\Backend 中对应的方法至此进行重写
     */
}