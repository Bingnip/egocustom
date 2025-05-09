<?php
declare (strict_types=1);

namespace app\admin\controller\mailManage;

use app\admin\model\mailManage as MailManage;
use app\common\controller\Backend;
use Throwable;

/**
 * 静态区域
 */
class EmailTemplate extends Backend
{
    protected object $model;

    protected string|array $quickSearchField = ['et_key', 'et_title', 'et_desc', 'et_content'];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new MailManage\EmailTemplate();
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

    public function add(): void
    {
        if (!$this->request->isPost()) $this->error(__('Post error'));
        $post = $this->request->getInput();
        $post = json_decode($post, true) ?? [];
        if (!$post) $this->error(__('Parameter %s can not be empty', ['et_key', 'et_title', 'et_desc', 'et_content']));

        if ($this->modelValidate) {
            try {
                $validate = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                $validate = new $validate();
                $validate->check($post);
            } catch (Throwable $e) {
                $this->error($e->getMessage());
            }
        }

        $key = $post['et_key'];
        if (!preg_match('/^[a-z0-9_]+$/', $key)) $this->error('【标识符】仅限小写字母、数字、下划线');
        $result = $this->model->add($post);
        if (!$result) $this->error(__('No rows were added'));
        $this->success(__('Added successfully'));
    }

    public function edit(): void
    {
        if ($this->request->isPost()) {
            $post = $this->request->getInput();
            $post = json_decode($post, true) ?? [];
            if (!$post) $this->error(__('Parameter %s can not be empty', ['et_key', 'et_title', 'et_desc', 'et_content']));

            if ($this->modelValidate) {
                try {
                    $validate = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    $validate = new $validate();
                    $validate->check($post);
                } catch (Throwable $e) {
                    $this->error($e->getMessage());
                }
            }

            $isExist = $this->model->getRowByKey($post['et_key'], intval($post['et_id']));
            if ($isExist) $this->error('标识符已存在，请更改');

            $id = $post['et_id'];
            $this->model->updateRowById($id, $post);
            $this->success('保存成功');
        } else {
            $id   = $this->request->param('et_id');
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