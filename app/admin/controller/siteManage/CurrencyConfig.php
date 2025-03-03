<?php
declare (strict_types=1);

namespace app\admin\controller\siteManage;

use app\admin\model\siteManage as SiteManageModel;
use app\common\controller\Backend;

class CurrencyConfig extends Backend
{
    protected object $model;

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new SiteManageModel\CurrencyConfig();
    }

    public function index(): void
    {
        $list = $this->model->getList();

        $this->success('', [
            'list'   => $list,
            'total'  => 2,
            'remark' => get_route_remark(),
        ]);
    }
}