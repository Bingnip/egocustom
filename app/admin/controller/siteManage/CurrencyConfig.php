<?php
declare (strict_types=1);

namespace app\admin\controller\siteManage;

use app\admin\model\siteManage as SiteManage;
use app\common\controller\Backend;
use Throwable;

/**
 * 货币管理
 */
class CurrencyConfig extends Backend
{
    protected object $model;

    protected string|array $quickSearchField = ['序号'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new SiteManage\CurrencyConfig();
    }

    /**
     * 若需重写查看、编辑、删除等方法，请复制 @see \app\admin\library\traits\Backend 中对应的方法至此进行重写
     */
    public function index(): void
    {
        $params = $this->request->param();
        $where = !empty($params) && isset($params['search']) ? array_column($params['search'], 'val', 'field') : [];

        $list = $this->model->getList($where);
        $count = $this->model->getCount($where);

        $this->success('', [
            'list'   => $list,
            'total'  => $count,
            'remark' => get_route_remark(),
        ]);
    }

    public function add(): void
    {
        if (!$this->request->isPost()) $this->error(__('Post error'));
        $post = $this->request->post();

        if ($this->modelValidate) {
            try {
                $validate = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                $validate = new $validate();
                $validate->check($post);
            } catch (Throwable $e) {
                $this->error($e->getMessage());
            }
        }

        $isExist = $this->model->getRowByCode($post['crc_code']);
        if ($isExist) $this->error('货币Code已存在');

        if ($post['crc_default'] == 1) {
            $haveDefault = $this->model->getDefault();
            if ($haveDefault) $this->error('已设置默认，请先变更');
        }

        $result = $this->model->add($post);
        if (!$result) $this->error(__('No rows were added'));
        $this->success(__('Added successfully'));
    }

    public function edit(): void
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();

            if ($this->modelValidate) {
                try {
                    $validate = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    $validate = new $validate();
                    $validate->check($post);
                } catch (Throwable $e) {
                    $this->error($e->getMessage());
                }
            }
            $crcId = $post['crc_id'];
            $this->model->updateRowById($crcId, $post);
            $this->success('保存成功');
        } else {
            $id   = $this->request->param('crc_id');
            $info = $this->model->getRowById($id);
            $this->success('', ['row' => $info]);
        }
    }

    public function del(array $ids = []): void
    {
        if (!$this->request->isDelete() || !$ids) $this->error(__('Parameter error'));

        $result = $this->model->remove($ids);
        $this->success('删除成功');
    }
}