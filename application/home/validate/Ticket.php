<?php
/**
 * Created by PhpStorm.
 * User: 57839
 * Date: 2018/8/8
 * Time: 16:44
 */

namespace app\home\validate;


use think\Validate;

class Ticket extends Validate
{
    protected $rule = [
        ['name', 'require', '保修人不能为空'],
        ['title', 'require', '标题不能为空'],
        ['tel', 'require', '电话不能为空'],
        ['address', 'require', '地址不能为空'],
        ['content', 'require', '内容不能为空'],
    ];
}