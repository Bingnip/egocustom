<?php

namespace app\admin\validate\siteManage;

use think\Validate;

class Shipping extends Validate
{
    protected $failException = true;

    /**
     * 验证规则
     */
    protected $rule = [
        'ship_code'  => 'require|regex:^[a-z0-9_-]+$',
        'ship_name'  => 'require',
        'ship_full_name'  => 'require',
    ];

    /**
     * 提示消息
     */
    protected $message = [
    ];

    /**
     * 验证场景
     */
    protected $scene = [
        'add' => ['ship_code', 'ship_name', 'ship_full_name'],
    ];


    public function __construct()
    {
        $this->field   = [
            'ship_code'  => __('ship_code'),
            'ship_name'  => __('ship_name'),
            'ship_full_name'  => __('ship_full_name'),
        ];
        $this->message = array_merge($this->message, [
            'ship_code.regex' => '【Code只允许小写英文、下划线】',
            'ship_name.regex' => '请填写【物流名】',
            'ship_full_name.regex' => '请填写【物流全称】',
        ]);
        parent::__construct();
    }

}
