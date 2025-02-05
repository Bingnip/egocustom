<?php

namespace app\admin\model;

use think\facade\Db;
use think\Model;
use think\model\relation\BelongsTo;

/**
 * Gallery 模型
 */
class Attachment extends Model
{
    public function getAttachmentFolderList(): array
    {
        return Db::name('attachment_folder')
            ->where('af_deleted_at', 0)
            ->order('af_order', 'desc')
            ->select()
            ->toArray();
    }

    public function getAttachmentUsedFolder(): array
    {
        return Db::name('attachment_folder')
            ->where('af_deleted_at', 0)
            ->where('af_id', '<>', 1)
            ->order('af_order', 'desc')
            ->select()
            ->toArray();
    }


    public function renameImg($id, $newName)
    {
        return Db::name('attachment')
            ->where('id', $id)
            ->update(['name' => $newName]);
    }

    public function moveImage($folderId, $idArr)
    {
        return Db::name('attachment')
            ->whereIn('id', $idArr)
            ->update(['af_id' => $folderId]);
    }

}