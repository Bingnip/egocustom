<?php

namespace app\admin\validate\mailManage;

use think\Validate;

class EmailTemplate extends Validate
{
    protected $failException = true;

    protected $rule = [
        'et_subject'  => 'require',
        'et_title'  => 'require',
        'et_key'  => 'require|regex:^[a-z0-9_]+$',
        'et_content'  => 'require',
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
        'add' => ['et_subject', 'et_title', 'et_key', 'et_content'],
    ];


    public function __construct()
    {
        $this->field   = [
            'et_subject'  => __('et_subject'),
            'et_title'  => __('et_key'),
            'et_content'  => __('et_content'),
            'et_key'  => __('et_key'),
        ];
        $this->message = array_merge($this->message, [
            'et_subject.regex' => '【标题】仅限小写字母、数字、下划线',
            'et_title.regex' => '请填写【模版名称】',
            'et_content.regex' => '请填写【正文】',
            'et_key.regex' => '请填写【标识符】',
        ]);
        parent::__construct();
    }
}