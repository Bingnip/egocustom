<?php

namespace app\admin\model\siteManage;

use think\facade\Db;
use think\Model;


class CurrencyConfig extends Model
{
    protected $tableName = 'currency';

    protected $autoWriteTimestamp = true;
    protected $updateTime         = true;

    public function getList(): array
    {
        return Db::name($this->tableName)->order(['crc_default' => 'desc','crc_order' => 'desc'])->select()->toArray();
    }


}