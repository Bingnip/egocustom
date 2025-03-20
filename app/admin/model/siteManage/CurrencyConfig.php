<?php

namespace app\admin\model\siteManage;

use think\facade\Db;
use think\Model;


class CurrencyConfig extends Model
{
    protected $tableName = 'currency_config';

    protected $autoWriteTimestamp = true;
    protected $updateTime         = true;

    public function getList(): array
    {
        return Db::name($this->tableName)->order(['crc_default' => 'desc', 'crc_order' => 'desc'])->select()->toArray();
    }

    public function updateRowById(int $id, array $data): bool
    {
        $data['crc_updated_at'] = time();
        return Db::name($this->tableName)->where(['crc_id' => $id])->update($data);
    }

    public function add(array $data): bool
    {
        $data['crc_created_at'] = time();
        return Db::name($this->tableName)->insert($data);
    }

    public function getRowByCode($code): bool|array
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