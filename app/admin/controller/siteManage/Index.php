<?php
declare (strict_types=1);

namespace app\admin\controller\siteManage;

use Throwable;
use app\common\controller\Backend;
use app\admin\model\SiteManage as SiteManage;

class Index extends Backend
{
    protected object $model;

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new SiteManage();
    }

    public function getList(): void
    {
        $list = $this->model->getSysConfig();
        $newList = [];

        if ($list) {
            foreach ($list as $k => $v) {
                switch ($v['sc_group']) {
                    case 10:
                        $newList['system'][] = $v;
                        break;
                    case 20:
                        $newList['logo'][] = $v;
                        break;
                    case 30:
                        $newList['mail'][] = $v;
                        break;
                    case 40:
                        $newList['thirdParty'][] = $v;
                        break;
                    case 50:
                        $newList['other'][] = $v;
                        break;
                    default:
                        $newList['null'][] = $v;
                        break;
                }
            }
        }

        $this->success('success', $newList);
    }
}
