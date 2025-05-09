<?php

namespace app\admin\validate\cmsManage;

use think\Validate;

class StaticBlock extends Validate
{
    protected $failException = true;

    protected $rule = [
        'cb_name'  => 'require|regex:^[a-z0-9_]+$',
        'cb_key'  => 'require',
        'cb_content'  => 'require',
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
        'add' => ['cb_name', 'cb_key', 'cb_content'],
    ];


    public function __construct()
    {
        $this->field   = [
            'cb_name'  => __('cb_name'),
            'cb_key'  => __('cb_key'),
            'cb_content'  => __('cb_content'),
        ];
        $this->message = array_merge($this->message, [
            'cb_name.regex' => '【名称】仅限小写字母、数字和下划线',
            'cb_key.regex' => '请填写【标识符】',
            'cb_content.regex' => '请填写【内容】',
        ]);
        parent::__construct();
    }
}