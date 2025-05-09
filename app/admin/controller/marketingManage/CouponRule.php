<?php

namespace app\admin\controller\marketingManage;

use app\admin\model\marketingManage as MarketingManage;
use app\common\controller\Backend;

/**
 * 优惠券规则管理
 */
class CouponRule extends Backend
{
    /**
     * CouponRule模型对象
     * @var object
     */
    protected object $model;

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new MarketingManage\CouponRule();
    }


    /**
     * 若需重写查看、编辑、删除等方法，请复制 @see \app\admin\library\traits\Backend 中对应的方法至此进行重写
     */
}