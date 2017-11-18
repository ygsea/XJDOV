<?php 
/**
 * 站点首页模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}

if(isset($_GET["setting"])){
	require_once View::getView('setting');
	exit;
}
if(isset($_GET["user"])){
	require_once View::getView('user');
	exit;
}
$view='';

if(isset($_COOKIE["emlog_dux_mothod"])){
	$web_method = $_COOKIE["emlog_dux_mothod"];
}

if($web_method==2){
	$view='module/m_blog';
}elseif($web_method==3){
	$view='module/m_gfs';
}elseif($web_method==4){
	$view='module/m_image';
}elseif($web_method==1){
	$view='module/m_cms3';//m_zazhi
}
if(!blog_tool_ishome()){
	if($web_method==4){
		$view='module/m_image';
	}else{
		$view='module/m_blog';
	}
	
}

//测试模板模式
if(isset($_GET["blog"])){
	setcookie("emlog_dux_mothod","2");
	$view='module/m_blog';
}elseif(isset($_GET["gfs"])){
	setcookie("emlog_dux_mothod","3");
	$view='module/m_gfs';	
}elseif(isset($_GET["image"])){
	setcookie("emlog_dux_mothod","4");
	$view='module/m_image';
}elseif(isset($_GET["zazhi"])){
	setcookie("emlog_dux_mothod","1");
	$view='module/m_cms3';
}

include View::getView($view);
?>
