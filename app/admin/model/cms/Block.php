<?php

namespace app\admin\model\cms;

use think\Model;

/**
 * Block
 */
class Block extends Model
{
    // 表主键
    protected $pk = '编号';

    // 表名
    protected $name = 'cms_block';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

}