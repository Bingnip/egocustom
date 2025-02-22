<?php
declare (strict_types=1);

namespace app\admin\controller\siteManage;

use think\Facade;
use think\facade\Log;
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
                foreach ($data as $k => $v) {
                    $update[$v['sc_key']] = $v['sc_value'];
                }
                break;
            case 20:
                $data = $form['log'];
                foreach ($data as $k => $v) {
                    $update[$v['sc_key']] = $v['sc_value'];
                }
                break;
            case 30:
                $data = $form['mail'];
                foreach ($data as $k => $v) {
                    $update[$v['sc_key']] = $v['sc_value'];
                }
                break;
            case 40:
                $data = $form['thirdParty'];
                foreach ($data as $k => $v) {
                    $update[$v['sc_key']] = $v['sc_value'];
                }
                break;
            case 50:
                $data = $form['other'];
                foreach ($data as $k => $v) {
                    $update[$v['sc_key']] = $v['sc_value'];
                }
                break;
        }

        $res = $this->model->saveSysConfig($update);
        logger($res);

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
