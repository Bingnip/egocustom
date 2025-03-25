<?php

namespace app\admin\model\siteManage;

use think\facade\Db;
use think\Model;


class CurrencyConfig extends Model
{
    protected $tableName = 'currency_config';

    public function getList(array $where): array
    {
        $query = Db::name($this->tableName);

        $query->where(function ($query) use ($where) {
            if (!$where) return false;

            if (isset($where['crc_name'])) {
                $query->where('crc_name', 'LIKE', '%' . $where['crc_name'] . '%');
            }
        });

        $order = ['crc_default' => 'desc', 'crc_order' => 'desc'];

        return $query->order($order)->select()->toArray();
    }

    public function getCount(array $where): int
    {
        $query = Db::name($this->tableName);

        $query->where(function ($query) use ($where) {
            if (isset($where['crc_name'])) {
                $query->where('crc_name', $where['crc_name']);
            }
        });

        return $query->count();
    }

    public function updateRowById(int|string $id, array $data): bool
    {
        $data['crc_updated_at'] = time();
        return Db::name($this->tableName)->where(['crc_id' => $id])->update($data);
    }

    public function add(array $data): bool
    {
        $data['crc_created_at'] = time();
        return Db::name($this->tableName)->insert($data);
    }

    public function getRowByCode(string $code): bool|array
    {
        $row = Db::name($this->tableName)
            ->where('crc_code', $code)
            ->find();

        return $row ?: false;
    }

    public function getRowById($id): bool|array
    {
        $row = Db::name($this->tableName)->where('crc_id', $id)->find();

        return $row ?: false;
    }

    public function getDefault(): bool
    {
        $row = Db::name($this->tableName)
            ->where('crc_default', 1)
            ->find();

        return (bool)$row;
    }

    public function remove(array $ids = []): bool
    {
        $result = Db::name($this->tableName)->where('crc_id', 'in', $ids)->delete();
        return $result != false;
    }
}