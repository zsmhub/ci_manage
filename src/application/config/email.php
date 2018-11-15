<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 邮箱配置
 */
//邮件协议常用端口
$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.exmail.qq.com',
    'smtp_port' => 25,
    'smtp_user' => 'your email',
    'smtp_pass' => 'your password',
    'mailtype' => 'html'
);

//基于SSL安全协议端口配置
/*$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.exmail.qq.com',
    'smtp_port' => 465,
    'smtp_user' => 'your email',
    'smtp_pass' => 'your password',
    'mailtype' => 'html'
);*/
