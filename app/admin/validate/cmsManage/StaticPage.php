<?php

namespace app\admin\validate\cmsManage;

use think\Validate;

class StaticPage extends Validate
{
    protected $failException = true;

    protected $rule = [
        'pb_title'  => 'require',
        'pb_url_key'  => 'require|regex:^[a-z0-9_-]+$',
        'pb_content'  => 'require',
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
        'add' => ['pb_title', 'pb_url_key', 'pb_content'],
    ];


    public function __construct()
    {
        $this->field   = [
            'pb_title'  => __('pb_title'),
            'pb_url_key'  => __('pb_url_key'),
            'pb_content'  => __('pb_content'),
        ];
        $this->message = array_merge($this->message, [
            'pb_title.regex' => '【标题】仅限小写字母、数字、横杠、下划线',
            'pb_url_key.regex' => '请填写【URL KEY】',
            'pb_content.regex' => '请填写【正文】',
        ]);
        parent::__construct();
    }
}