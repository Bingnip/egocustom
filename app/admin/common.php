<?php

use ba\Filesystem;
use think\facade\Log;

if (!function_exists('get_controller_list')) {
    function get_controller_list($app = 'admin'): array
    {
        $controllerDir = root_path() . 'app' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR;
        return Filesystem::getDirFiles($controllerDir);
    }
}

if (!function_exists('logger')) {
    function logger($post): void
    {
        $res = json_encode($post, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        Log::instance()->info($res);
    }
}

/**
 * 通用的校验方法
 */
if (!function_exists('commonValidate')) {
    function commonValidate($params): array|object|int|null
    {
        if (empty($params)) return $params;

        if (is_object($params)) {
            foreach ($params as $k => $v) {
                $params->$k = deepAddSlashes($v);
            }
        } else {
            $params = deepAddSlashes($params);
        }

        return $params;
    }

    function deepAddSlashes(mixed $v): string|array
    {
        if (empty($v)) return $v;
        if (is_array($v)) {
            return array_map('deepAddSlashes', $v);
        } else if (is_numeric($v)){
            return intval($v);
        } else {
            return addslashes($v);
        }
    }
}

