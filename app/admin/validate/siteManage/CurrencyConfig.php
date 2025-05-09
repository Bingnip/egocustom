<?php

namespace app\admin\validate\siteManage;

use think\Validate;

class CurrencyConfig extends Validate
{
    protected $failException = true;

    protected $rule = [
        'crc_code'  => 'require|regex:^[A-Z]{3}$',
        'crc_name'  => 'require',
        'crc_sign'  => 'require',
        'crc_icon'  => 'require'
    ];

    /**
     * 验证提示信息
     * @var array
     */
    protected $message = [];

    /**
     * 字段描述
     */
    protected $field = [
    ];

    /**
     * 验证场景
     */
    protected $scene = [
        'add' => ['crc_code', 'crc_name', 'crc_sign', 'crc_icon'],
    ];


    public function __construct()
    {
        $this->field   = [
            'crc_code'  => __('crc_code'),
            'crc_name'  => __('crc_name'),
            'crc_sign'  => __('crc_sign'),
            'crc_icon'  => __('crc_icon'),
        ];
        $this->message = array_merge($this->message, [
            'crc_code.regex' => '【Code】必须大写字母',
            'crc_name.regex' => '请填写【货币名称】',
            'crc_sign.regex' => '请填写【货币符号】',
            'crc_icon.regex' => '请填写【货币图标】',
        ]);
        parent::__construct();
    }
}