<?php

namespace app\admin\controller;

use app\admin\model\Attachment as AttachmentModel;
use app\common\controller\Backend;
use think\facade\Log;

class Gallery extends Backend
{
    /**
     * @var object
     * @phpstan-var AttachmentModel
     */
    protected object $model;

    protected array $withJoinTable = [];

    // 排除字段
    protected array $preExcludeFields = [];

    public function initialize(): void
    {
        parent::initialize();
        $this->model = new AttachmentModel();
    }

    public function getGalleryAll(): void
    {
        $fdId = $this->request->get("fdId/d", 1);
        list($where, $alias, $limit, $order) = $this->queryBuilder();

        $res = $this->model->alias($alias)
            ->where($where)
            ->where('af_id', $fdId)
            ->order($order)
            ->paginate($limit);

        $this->success('', [
            'folderList' => $this->model->getAttachmentFolderList(),
            'usedFolderList' => $this->model->getAttachmentUsedFolder(),
            'list'   => $res->items(),
            'total'  => $res->total(),
            'remark' => get_route_remark(),
        ]);
    }

    public function renameImgSubmit(): void
    {
        $id = $this->request->post("id/d", 0);
        $newName = $this->request->post("name/s", '');

        $this->model->renameImg($id, filter($newName));

        $this->success('修改成功');
    }

    public function moveImage()
    {
        $folderId = $this->request->post("folderId/d", 0);
        $idArr = $this->request->post("ids", []);

        $this->model->moveImage($folderId, $idArr);

        $this->success('移动成功');
    }
}