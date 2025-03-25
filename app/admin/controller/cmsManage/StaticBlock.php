<?php
declare (strict_types=1);

namespace app\admin\controller\cmsManage;

use app\admin\model\cmsManage as CmsManage;
use app\common\controller\Backend;
use Throwable;

/**
 * 静态区域
 */
class StaticBlock extends Backend
{
    protected object $model;

    protected string|array $quickSearchField = ['cb_key', 'cb_name'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new CmsManage\StaticBlock();
    }

    public function index(): void
    {
        $params = $this->request->param();
        $list = $this->model->getList($params);
        $count = $this->model->getCount($params);

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
        if (!$post) $this->error(__('Parameter %s can not be empty', ['cb_name', 'cb_key', 'cb_content']));

        if ($this->modelValidate) {
            try {
                $validate = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                $validate = new $validate();
                $validate->check($post);
            } catch (Throwable $e) {
                $this->error($e->getMessage());
            }
        }

        $cbKey = $post['cb_key'];
        if (!preg_match('/^[a-z0-9_]+$/', $cbKey)) $this->error('【标识符】仅限小写字母、数字和下划线');

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

            $isExist = $this->model->getRowByKey($post['cb_key']);
            if ($isExist) $this->error('已添加存在');

            $cbId = $post['cb_id'];
            $this->model->updateRowById($cbId, $post);
            $this->success('保存成功');
        } else {
            $id   = $this->request->param('cb_id');
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