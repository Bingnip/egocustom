<?php

namespace app\admin\model\static;

use think\Model;

/**
 * Page
 */
class Page extends Model
{
    // 表主键
    protected $pk = 'pb_id';

    // 表名
    protected $name = 'static_page';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;


    public function getPbContentAttr($value): string
    {
        return !$value ? '' : htmlspecialchars_decode($value);
    }
}