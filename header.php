<?php
/*
Template Name:XJDOV
Description:<span style="color:red">有空多到我的博客做客哈~</span>>><a href="https://www.xjdog.cn/">小俊</a></br>模板设置：>><a href="../?setting">设置</a>
Version:1.0
Author:小俊
Author Url:https://www.xjdog.cn/
Sidebar Amount:2
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}

define("THEME_VER","4.5");

ini_set('date.timezone','Asia/Shanghai');

require_once View::getView('config');

global $arr_navico1;
$arr_navico1 = unserialize($arr_navico);
global $arr_sortico1;
$arr_sortico1 = unserialize($arr_sortico);

require_once View::getView('module');

require_once View::getView('function');

require_once View::getView('module/m-header');
?>
