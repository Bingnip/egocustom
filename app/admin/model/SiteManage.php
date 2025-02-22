<?php

namespace app\admin\model;

use think\facade\Db;
use think\Model;
use think\model\relation\BelongsTo;

/**
 * SiteManage 模型
 */
class SiteManage extends Model
{
    protected $tableName = 'sys_config';

    protected $autoWriteTimestamp = true;
    protected $updateTime         = true;

    public function getSysConfig(): array
    {
        return Db::name($this->tableName)->order(['sc_id' => 'asc','sc_order' => 'desc'])->select()->toArray();
    }

    public function saveSysConfig($update): bool
    {
        return Db::name($this->tableName)
            ->update([]);
    }
}