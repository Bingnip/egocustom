<?php
declare (strict_types=1);

namespace app\admin\controller\siteManage;

use app\admin\model\siteManage as SiteManage;
use app\common\controller\Backend;
use Throwable;

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

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new SiteManage\Shipping();
    }

    public function index(): void
    {
        $params = $this->request->param();
        $where  = !empty($params) && isset($params['search']) ? array_column($params['search'], 'val', 'field') : [];

        $list  = $this->model->getList($where);
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
        logger($post);
        if ($this->modelValidate) {
            try {
                $validate = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                $validate = new $validate();
                $validate->check($post);
            } catch (Throwable $e) {
                $this->error($e->getMessage());
            }
        }

        $isExist = $this->model->getRowByCode($post['ship_code']);
        if ($isExist) $this->error('物流code已存在');

        $result = $this->model->add($post);
        if (!$result) $this->error(__('No rows were added'));
        $this->success(__('Added successfully'));
    }

    public function edit(): void
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (!$post) $this->error(__('Parameter %s can not be empty', ['ship_id']));

            if ($this->modelValidate) {
                try {
                    $validate = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    $validate = new $validate();
                    $validate->check($post);
                } catch (Throwable $e) {
                    $this->error($e->getMessage());
                }
            }

            $isExist = $this->model->getRowByCode($post['ship_code'], intval($post['ship_id']));
            if ($isExist) $this->error('物流code已存在，请更改');

            $id = intval($post['ship_id']);
            $this->model->updateRowById($id, $post);
            $this->success('保存成功');
        } else {
            $id   = $this->request->param('ship_id');
            $info = $this->model->getRowById(intval($id));
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