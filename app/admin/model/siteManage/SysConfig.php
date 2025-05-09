<?php

namespace app\admin\model\siteManage;

use think\facade\Db;
use think\Model;

/**
 * SiteManage 模型
 */
class SysConfig extends Model
{
    protected $tableName = 'sys_config';

    protected $autoWriteTimestamp = true;
    protected $updateTime         = true;

    public function getSysConfig(): array
    {
        return Db::name($this->tableName)->order(['sc_id' => 'asc','sc_order' => 'desc'])->select()->toArray();
    }

    public function saveSysConfig($key, $value): bool
    {
        return Db::name($this->tableName)->where('sc_key', $key)
            ->update(['sc_value' => $value]);
    }

}