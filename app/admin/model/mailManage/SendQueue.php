<?php

namespace app\admin\model\mailManage;

use think\facade\Db;
use think\Model;

/**
 * Block
 */
class SendQueue extends Model
{
    // 表名
    protected $name = 'email_queue';

    public function getList(array $where = []): array
    {
        $query = Db::name($this->name);

        $query->where(function ($query) use ($where) {
            if (isset($where['eq_title'])) {
                $query->where('eq_title', 'LIKE', '%' . $where['eq_title'] . '%');
            }
            if (isset($where['eq_key'])) {
                $query->where('eq_key', 'LIKE', '%' . $where['eq_key'] . '%');
            }
            if (isset($where['eq_status'])) {
                $query->where('eq_status', '=', $where['eq_status']);
            }
        });

        $order = ['eq_id' => 'desc'];

        return $query->order($order)->select()->toArray();
    }

    public function getCount(array $where = []): int
    {
        $query = Db::name($this->name);

        $query->where(function ($query) use ($where) {
            if (isset($where['eq_title'])) {
                $query->where('eq_title', 'LIKE', '%' . $where['eq_title'] . '%');
            }
            if (isset($where['eq_key'])) {
                $query->where('eq_key', 'LIKE', '%' . $where['eq_key'] . '%');
            }
            if (isset($where['eq_status'])) {
                $query->where('eq_status', '=', $where['eq_status']);
            }
        });

        return $query->count();
    }


    public function getRowById($id): bool|array
    {
        $row = Db::name($this->name)->where('eq_id', $id)->find();

        return $row ?: false;
    }

    public function remove(array $ids = []): bool
    {
        $result = Db::name($this->name)->where('eq_id', 'in', $ids)->delete();
        return $result != false;
    }

}