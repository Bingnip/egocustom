<?php
declare (strict_types=1);

namespace app\admin\controller\siteManage;

use app\admin\model\siteManage as SiteManage;
use app\common\controller\Backend;

class SysConfig extends Backend
{
    protected object $model;

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new SiteManage\SysConfig();
    }

    public function saveConfig(): bool|object
    {
        if (!$this->request->isPost()) return false;
        $post = $this->request->post();
        $type = intval($post['type']);
        $form = commonValidate($post['form']);
        $update = [];

        switch ($type) {
            case 10:
                $data = $form['system'];
                break;
            case 20:
                $data = $form['log'];
                break;
            case 30:
                $data = $form['mail'];
                break;
            case 40:
                $data = $form['thirdParty'];
                break;
            case 50:
                $data = $form['other'];
                break;
        }

        foreach ($data as $k => $v) {
            $this->model->saveSysConfig($v['sc_key'], $v['sc_value']);
        }

        $this->success('保存成功');
    }

    public function getList(): array
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
