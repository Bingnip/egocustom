<?php

namespace app\admin\model\mailManage;

use think\facade\Db;
use think\Model;

/**
 * Block
 */
class EmailTemplate extends Model
{
    // 表名
    protected $tableName = 'email_template';

    public function getList(array $where = []): array
    {
        $query = Db::name($this->tableName);

        $query->where(function ($query) use ($where) {
            if (isset($where['et_title'])) {
                $query->where('et_title', 'LIKE', '%' . $where['et_title'] . '%');
            }
            if (isset($where['et_key'])) {
                $query->where('et_key', 'LIKE', '%' . $where['et_key'] . '%');
            }
            if (isset($where['et_status'])) {
                $query->where('et_status', '=', $where['et_status']);
            }
        });

        $order = ['et_id' => 'desc'];

        return $query->order($order)->select()->toArray();
    }

    public function getCount(array $where = []): int
    {
        $query = Db::name($this->tableName);

        $query->where(function ($query) use ($where) {
            if (isset($where['et_title'])) {
                $query->where('et_title', 'LIKE', '%' . $where['et_title'] . '%');
            }
            if (isset($where['et_key'])) {
                $query->where('et_key', 'LIKE', '%' . $where['et_key'] . '%');
            }
            if (isset($where['et_status'])) {
                $query->where('et_status', '=', $where['et_status']);
            }
        });

        return $query->count();
    }

    public function add(array $data): bool
    {
        $data['et_created_at'] = time();
        return Db::name($this->tableName)->insert($data);
    }

    public function getRowByKey(string $key, int $id): bool|array
    {
        $row = Db::name($this->tableName)
            ->where('et_key', $key)
            ->where('et_id', '<>', $id)
            ->find();

        return $row ?: false;
    }

    public function updateRowById(int|string $id, array $data): bool
    {
        $data['et_updated_at'] = time();
        return Db::name($this->tableName)->where(['et_id' => $id])->update($data);
    }

    public function getRowById($id): bool|array
    {
        $row = Db::name($this->tableName)->where('et_id', $id)->find();

        return $row ?: false;
    }

    public function remove(array $ids = []): bool
    {
        $result = Db::name($this->tableName)->where('et_id', 'in', $ids)->delete();
        return $result != false;
    }

}