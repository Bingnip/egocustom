<?php

namespace app\admin\model\siteManage;

use think\Model;

/**
 * Shipping
 */
class Shipping extends Model
{
    // 表主键
    protected $pk = 'ship_id';

    // 表名
    protected $name = 'shipping';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

}