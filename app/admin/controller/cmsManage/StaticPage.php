<?php
declare (strict_types=1);

namespace app\admin\controller\cmsManage;

use app\admin\model\cmsManage as CmsManage;
use app\common\controller\Backend;
use Throwable;

/**
 * 静态区域
 */
class StaticPage extends Backend
{
    protected object $model;

    protected string|array $quickSearchField = ['pb_key', 'pb_title', 'pb_status'];
    # todo 缓存刷新要写下
    public function initialize(): void
    {
        parent::initialize();
        $this->model = new CmsManage\StaticPage();
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
        $post = $this->request->post();
        if (!$post) $this->error(__('Parameter %s can not be empty', ['pb_url_key', 'pb_title', 'pb_status', 'pb_content']));

        if ($this->modelValidate) {
            try {
                $validate = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                $validate = new $validate();
                $validate->check($post);
            } catch (Throwable $e) {
                $this->error($e->getMessage());
            }
        }

        $key = $post['pb_url_key'];
        if (!preg_match('/^[a-z0-9_-]+$/', $key)) $this->error('【标识符】仅限小写字母、数字、横杠、下划线');
        $result = $this->model->add($post);
        if (!$result) $this->error(__('No rows were added'));
        $this->success(__('Added successfully'));
    }

    public function edit(): void
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (!$post) $this->error(__('Parameter %s can not be empty', ['pb_url_key', 'pb_title', 'pb_status', 'pb_content']));

            if ($this->modelValidate) {
                try {
                    $validate = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    $validate = new $validate();
                    $validate->check($post);
                } catch (Throwable $e) {
                    $this->error($e->getMessage());
                }
            }

            $isExist = $this->model->getRowByKey($post['pb_url_key'], intval($post['pb_id']));
            if ($isExist) $this->error('URL KEY 已存在，请更改');

            $id = $post['pb_id'];
            $this->model->updateRowById($id, $post);
            $this->success('保存成功');
        } else {
            $id   = $this->request->param('pb_id');
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