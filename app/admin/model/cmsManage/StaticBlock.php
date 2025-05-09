<?php

namespace app\admin\model\cmsManage;

use think\facade\Db;
use think\Model;

/**
 * Block
 */
class StaticBlock extends Model
{
    // 表名
    protected $tableName = 'static_block';

    public function getList(array $where = []): array
    {
        $query = Db::name($this->tableName);

        $query->where(function ($query) use ($where) {
            if (isset($where['cb_name'])) {
                $query->where('cb_name', 'LIKE', '%' . $where['cb_name'] . '%');
            }
            if (isset($where['cb_key'])) {
                $query->where('cb_key', 'LIKE', '%' . $where['cb_key'] . '%');
            }
            if (isset($where['cb_status'])) {
                $query->where('cb_status', '=', $where['cb_status']);
            }
        });

        $order = ['cb_id' => 'desc'];

        return $query->order($order)->select()->toArray();
    }

    public function getCount(array $where = []): int
    {
        $query = Db::name($this->tableName);

        $query->where(function ($query) use ($where) {
            if (isset($where['cb_name'])) {
                $query->where('cb_name', 'LIKE', '%' . $where['cb_name'] . '%');
            }
            if (isset($where['cb_key'])) {
                $query->where('cb_key', 'LIKE', '%' . $where['cb_key'] . '%');
            }
            if (isset($where['cb_status'])) {
                $query->where('cb_status', '=', $where['cb_status']);
            }
        });

        return $query->count();
    }

    public function add(array $data): bool
    {
        $data['cb_created_at'] = time();
        return Db::name($this->tableName)->insert($data);
    }

    public function getRowByKey(string $key, int $id): bool|array
    {
        $row = Db::name($this->tableName)
            ->where('cb_key', $key)
            ->where('cb_id', '<>', $id)
            ->find();

        return $row ?: false;
    }

    public function updateRowById(int|string $id, array $data): bool
    {
        $data['cb_updated_at'] = time();
        return Db::name($this->tableName)->where(['cb_id' => $id])->update($data);
    }

    public function getRowById($id): bool|array
    {
        $row = Db::name($this->tableName)->where('cb_id', $id)->find();

        return $row ?: false;
    }

    public function remove(array $ids = []): bool
    {
        $result = Db::name($this->tableName)->where('cb_id', 'in', $ids)->delete();
        return $result != false;
    }

}