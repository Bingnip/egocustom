<?php

namespace app\admin\model\cmsManage;

use think\facade\Db;
use think\Model;

/**
 * Block
 */
class StaticPage extends Model
{
    // 表名
    protected $tableName = 'static_page';

    public function getList(array $where = []): array
    {
        $query = Db::name($this->tableName);

        $query->where(function ($query) use ($where) {
            if (isset($where['pb_title'])) {
                $query->where('pb_title', 'LIKE', '%' . $where['pb_title'] . '%');
            }
            if (isset($where['pb_url_key'])) {
                $query->where('pb_url_key', 'LIKE', '%' . $where['pb_url_key'] . '%');
            }
            if (isset($where['pb_status'])) {
                $query->where('pb_status', '=', $where['pb_status']);
            }
        });

        $order = ['pb_id' => 'desc'];

        return $query->order($order)->select()->toArray();
    }

    public function getCount(array $where = []): int
    {
        $query = Db::name($this->tableName);

        $query->where(function ($query) use ($where) {
            if (isset($where['pb_title'])) {
                $query->where('pb_title', 'LIKE', '%' . $where['pb_title'] . '%');
            }
            if (isset($where['pb_url_key'])) {
                $query->where('pb_url_key', 'LIKE', '%' . $where['pb_url_key'] . '%');
            }
            if (isset($where['pb_status'])) {
                $query->where('pb_status', '=', $where['pb_status']);
            }
        });

        return $query->count();
    }

    public function add(array $data): bool
    {
        $data['pb_created_at'] = time();
        return Db::name($this->tableName)->insert($data);
    }

    public function getRowByKey(string $key, int $id): bool|array
    {
        $row = Db::name($this->tableName)
            ->where('pb_url_key', $key)
            ->where('pb_id', '<>', $id)
            ->find();

        return $row ?: false;
    }

    public function updateRowById(int|string $id, array $data): bool
    {
        $data['pb_updated_at'] = time();
        return Db::name($this->tableName)->where(['pb_id' => $id])->update($data);
    }

    public function getRowById($id): bool|array
    {
        $row = Db::name($this->tableName)->where('pb_id', $id)->find();

        return $row ?: false;
    }

    public function remove(array $ids = []): bool
    {
        $result = Db::name($this->tableName)->where('pb_id', 'in', $ids)->delete();
        return $result != false;
    }

}