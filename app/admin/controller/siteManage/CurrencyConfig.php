<?php
declare(strict_types=1);
namespace app\admin\controller\siteManage;

use app\admin\model\siteManage as SiteManageModel;
use app\common\controller\Backend;

/**
 * 货币管理
*/

class CurrencyConfig extends Backend
{
    /**
     * Currency模型对象
     * @var object
     * @phpstan-var \app\admin\model\Currency
     */
    protected object $model;

    protected string|array $quickSearchField = ['序号'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new SiteManageModel\CurrencyConfig();
    }

    /**
     * 若需重写查看、编辑、删除等方法，请复制 @see \app\admin\library\traits\Backend 中对应的方法至此进行重写
     */

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