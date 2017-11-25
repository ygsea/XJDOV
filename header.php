<?php
/*
Template Name: XJDOV
Description:<a href="http://www.xjdog.cn">小俊博客</a></br>模板设置：>><a href="./?setting">设置</a>
Version:1.0.1
Author:小俊
Author Url:http://wpa.qq.com/msgrd?v=3&uin=2647386761&site=qq&menu=yes
Sidebar Amount:2
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}

define("THEME_VER","4.4");

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

<link href="/OwO/OwO.min.css" rel="stylesheet" type="text/css" />
<script src="/OwO/OwO.min.js" type="text/javascript"></script>

<script type="text/javascript">// <![CDATA[
    jQuery(document).ready(function() {
    	function d() {
    		document.title = document[b] ? "小俊博客交流群：639687333" : a
    	}
    	var b, c, a = document.title;
    	"undefined" != typeof document.hidden ? (b = "hidden", c = "visibilitychange") : "undefined" != typeof document.mozHidden ? (b = "mozHidden", c = "mozvisibilitychange") : "undefined" != typeof document.webkitHidden && (b = "webkitHidden", c = "webkitvisibilitychange"), ("undefined" != typeof document.addEventListener || "undefined" != typeof document[b]) && document.addEventListener(c, d, !1)
    });
    
// ]]>
</script>

<script type="text/javascript">
(function () {
  var re = /x/;
  var i = 0;
  console.log(re);
 
  re.toString = function () {
    alert("小伙子 搞事情啊！");
    return '第 ' + (++i) + ' 次打开控制台';
  };
})();
</script>