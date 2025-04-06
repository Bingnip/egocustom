<?php

namespace app\admin\model\siteManage;

use think\facade\Db;
use think\Model;

/**
 * Shipping
 */
class Shipping extends Model
{
    protected $name = 'shipping';

    public function getList(array $where = []): array
    {
        $query = Db::name($this->name);

        $query->where(function ($query) use ($where) {
            if (isset($where['ship_name']) && $where['ship_name']) {
                $query->where('ship_name', 'LIKE', '%' . $where['ship_name'] . '%');
            }
            if (isset($where['ship_code']) && $where['ship_code']) {
                $query->where('ship_code', 'LIKE', '%' . $where['ship_code'] . '%');
            }
            if (isset($where['ship_full_name']) && $where['ship_full_name']) {
                $query->where('ship_full_name', 'LIKE', '%' . $where['ship_full_name'] . '%');
            }
            if (isset($where['ship_full_name']) && $where['ship_full_name']) {
                $query->where('ship_full_name', 'LIKE', '%' . $where['ship_full_name'] . '%');
            }
            if (isset($where['ship_status'])) {
                $query->where('ship_status', '=', $where['ship_status']);
            }
        });


        return $query->select()->toArray();
    }

    public function getCount(array $where = []): int
    {
        $query = Db::name($this->name);

        $query->where(function ($query) use ($where) {
            if (isset($where['ship_name']) && $where['ship_name']) {
                $query->where('ship_name', 'LIKE', '%' . $where['ship_name'] . '%');
            }
            if (isset($where['ship_code']) && $where['ship_code']) {
                $query->where('ship_code', 'LIKE', '%' . $where['ship_code'] . '%');
            }
            if (isset($where['ship_full_name']) && $where['ship_full_name']) {
                $query->where('ship_full_name', 'LIKE', '%' . $where['ship_full_name'] . '%');
            }
            if (isset($where['ship_full_name']) && $where['ship_full_name']) {
                $query->where('ship_full_name', 'LIKE', '%' . $where['ship_full_name'] . '%');
            }
            if (isset($where['ship_status'])) {
                $query->where('ship_status', '=', $where['ship_status']);
            }
        });

        return $query->count();
    }

    public function updateRowById(int $id = 0, array $post = []): bool|array
    {
        $row = Db::name($this->name)
            ->where('ship_id', $id)
            ->update($post);

        return $row ?: false;
    }

    public function getRowById(int $id = 0): bool|array
    {
        $row = Db::name($this->name)
            ->where('ship_id', $id)
            ->find();

        return $row ?: false;
    }

    public function getRowByCode(string $code, int $id = 0): bool|array
    {
        $row = Db::name($this->name)
            ->where('ship_code', $code)
            ->where('ship_id', '<>', $id)
            ->find();

        return $row ?: false;
    }

    public function add(array $data): bool
    {
        return Db::name($this->name)->insert($data);
    }

    public function remove(array $ids = []): bool
    {
        $data['ship_deleted_at'] = time();
        $result = Db::name($this->name)->where('ship_id', 'in', $ids)->update($data);
        return $result != false;
    }
}