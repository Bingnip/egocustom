<?php
declare (strict_types=1);

namespace app\admin\controller\mailManage;

use app\admin\model\mailManage as MailManage;
use app\common\controller\Backend;
use Throwable;

/**
 * 静态区域
 */
class SendQueue extends Backend
{
    protected object $model;

    protected string|array $quickSearchField = ['eq_key', 'eq_title', 'eq_desc', 'eq_content'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new MailManage\SendQueue();
    }

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

    public function getRow(): void
    {
        $params = $this->request->param();
        $id = $params['id'];

        $info = $this->model->getRowById($id);

        $this->success('', ['row' => $info]);
    }

    public function del(array $ids = []): void
    {
        if (!$this->request->isDelete() || !$ids) $this->error(__('Parameter error'));

        $result = $this->model->remove($ids);
        $this->success('删除成功');
    }
}