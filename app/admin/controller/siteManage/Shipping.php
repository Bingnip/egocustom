<?php

namespace app\admin\controller\siteManage;

use app\common\controller\Backend;

/**
 * 物流管理
 */
class Shipping extends Backend
{
    /**
     * Shipping模型对象
     * @var object
     * @phpstan-var \app\admin\model\siteManage\Shipping
     */
    protected object $model;

    protected array|string $preExcludeFields = ['ship_id'];

    protected string|array $quickSearchField = ['ship_id'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new \app\admin\model\siteManage\Shipping();
    }


    /**
     * 若需重写查看、编辑、删除等方法，请复制 @see \app\admin\library\traits\Backend 中对应的方法至此进行重写
     */
}