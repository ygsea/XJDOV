<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-title" content="emlog大前端">
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="description" content="<?php echo $site_description; ?>" />
<meta name="generator" content="emlog大前端" />
<title><?php echo $site_title; ?></title>
<link rel="shortcut icon" href="<?php echo TEMPLATE_URL; ?>favicon.ico">
<?php if($cdn_css==1): ?>
<link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
<script src="http://libs.baidu.com/jquery/1.8.0/jquery.min.js"></script>
<?php else: ?>
<link href="<?php echo TEMPLATE_URL; ?>style/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo TEMPLATE_URL; ?>style/font-awesome.min.css" rel="stylesheet">
<script src="<?php echo TEMPLATE_URL; ?>js/jquery.min.js"></script>
<?php endif; ?>
<link rel="stylesheet" id="da-main-css" href="<?php echo TEMPLATE_URL; ?>style/main.css?ver=4.5.1" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo TEMPLATE_URL; ?>style/prettify.css" type="text/css">
<!--[if lt IE 9]><script src="http://apps.bdimg.com/libs/html5shiv/r29/html5.min.js"></script><![endif]-->
<!-- <script language="javascript">if(top !== self){location.href = "about:blank";}</script> -->
<script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<style type="text/css">
.logo a{
	background-image:url("<?php echo $logo_url; ?>");
}
<?php 
	$styles .= $css;
	if($theme_skin == '45B6F7')$color = false;
	else $color = $theme_skin;
	if ($color) {
		$styles .= ".widget_links li a:hover,.m-nav-show .m-icon-nav,a:hover,.site-navbar a:hover,.site-navbar li.active > a,.topbar a:hover,.topmenu a:hover,.topmenu li.active > a,.site-search-form a:hover,.site-navbar .current a,.title .more li a:hover,.widget_ui_comments strong,.widget_ui_textads a.style01,.widget_ui_posts li a:hover .text,.widget_links li a .fa{color: #{$color};}
.plinks ul li a:hover,.search-input:focus,.widget_ui_textads a.style01:hover{border-color: #{$color};}
.label-primary,.search-btn,.submit,.widget_ui_textads a.style01 strong,.excerpt .cat,.widget_ui_tags .items a:hover ,.page_tags a:nth-child(9n):hover,.pagenavi a:hover, .pagenavi .now-page,.widget_ui_sort .items a:hover{background-color: #{$color};}
.btn-primary{background-color: #{$color}; border-color: #{$color};}
.excerpt h2 a:hover{color: #{$color};}
.sub_btn{background-color: #{$color};border: 1px solid #{$color};}";
	}
	echo $styles;
?>
</style>
<?php doAction('index_head'); ?></head>
<body class="home blog ">
<div id="wrap">
<header class="header">
<div class="container">
	<h1 class="logo"><a href="<?php echo BLOG_URL; ?>" title=""><?php echo $blogname; ?></a></h1>	<div class="brand"><?php echo $new_log_num; ?></div>
	<ul class="site-nav site-navbar">
		<?php blog_navi();?>
		<li class="navto-search"><a href="javascript:;" class="search-show active"><i class="fa fa-search"></i></a></li>
	</ul>
	<div class="topbar">
		<ul class="site-nav topmenu">
				<?php echo $home_toptext;?>
		</ul>
		
	</div>
	<i class="fa fa-bars m-icon-nav"></i>
</div>
</header>
<div class="site-search">
<div class="container">
	<form method="get" class="site-search-form" action="<?php echo BLOG_URL; ?>index.php">
		<input class="search-input" name="keyword" type="text" placeholder="输入关键字搜索"><button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
	</form>
</div>
</div>
<div class="pjax">