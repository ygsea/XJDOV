<?php 
/**
 * 阅读文章页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

<div class="single single-post postid- single-format-standard nav_fixed">

<section class="container"><div class="content-wrap"> <div class="content" style="margin-right:0px;">
<?php mianbao_sort($logid,$log_title);?>
 <header class="article-header"> <?php if(!empty($ad_page)):echo $ad_page;endif;?><h1 class="article-title"><?php topflg($top); ?><?php echo $log_title; ?></h1> <div class="article-meta"> 

		<span><i class="fa fa-calendar fa-fw"></i> 日期：<?php echo gmdate('Y-n-j', $date); ?> </span>
		<span><i class="fa fa-user"></i> <?php echo blog_author($author); ?></span>
		<span><i class="fa fa-book fa-fw"></i> <?php blog_sort($logid); ?></span>
		<span><i class="fa fa-fire fa-fw"></i> 浏览：<?php echo $views; ?>次 </span>
		<span><i class="fa fa-comments fa-fw"></i> 评论：<?php echo $comnum; ?>条</span> <?php editflg($logid,$author); ?>
</div> </header> <article class="article-content">

<?php echo  reply_view($log_content,$logid);?>

<span style="display:block;padding-top:40px;"></span>



</article> 
<?php if(!empty($ad_page_down)):echo $ad_page_down;endif;?>

</div> </div></div>
<?php
 include View::getView('footer');
?>


