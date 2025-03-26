<?php

namespace app\admin\controller\static;

use app\common\controller\Backend;

/**
 * 页面区域
 */
class Page extends Backend
{
    /**
     * Page模型对象
     * @var object
     * @phpstan-var \app\admin\model\static\Page
     */
    protected object $model;

    protected string|array $defaultSortField = 'pb_id,desc';

    protected string|array $quickSearchField = ['pb_id'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\static\Page();
        $this->request->filter('clean_xss');
    }


    /**
     * 若需重写查看、编辑、删除等方法，请复制 @see \app\admin\library\traits\Backend 中对应的方法至此进行重写
     */
}