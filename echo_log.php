<?php 
/**
 * 阅读文章页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<html xmlns:wb="http://open.weibo.com/wb">
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
<section class="container">
<div class="single single-post single-format-standard nav_fixed">
<div class="content-wrap"> <div class="content">
<script src="/content/templates/XJDOV/js/instantclick.min.js" data-no-instant></script>
<script data-no-instant>InstantClick.init();</script>
<script src="/content/templates/XJDOV/js/xjbk.js" data-no-instant></script>
<script>
POWERMODE.colorful = true; // make power mode colorful
POWERMODE.shake = false; // turn off shake
document.body.addEventListener('input', POWERMODE);
</script>

 <header class="article-header"> <?php if(!empty($ad_page)):echo $ad_page;endif;?><h1 class="article-title"><?php topflg($top); ?><?php echo $log_title; ?></h1> <div class="article-meta"> 

		<span><i class="fa fa-calendar fa-fw"></i> 日期：<?php echo gmdate('Y-n-j', $date); ?> </span>
		<span><i class="fa fa-user"></i> <?php echo blog_author($author); ?></span>
		<span><i class="fa fa-book fa-fw"></i> <?php blog_sort($logid); ?></span>
		<span><i class="fa fa-fire fa-fw"></i> 热度：<?php echo $views; ?>℃ </span>
		<span><i class="fa fa-comments fa-fw"></i> 评论：<?php echo $comnum; ?>条</span> <?php editflg($logid,$author); ?>
</div> </header> <article class="article-content">

<?php echo  reply_view($log_content,$logid);//文章回复可见?>

<span style="display:block;padding-top:40px;"></span>
<?php doAction('down_log',$logid); ?>

<div class="iblue">
<i class="fa fa-tags"></i> 本文标签：<?php blog_tag($logid); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<wb:follow-button uid="5773736699" type="red_1" width="67" height="24" ></wb:follow-button><br>
<i class="fa fa-share-alt-square"></i>本文链接：&nbsp; <a href="<?php echo Url::log($logid); ?>" target="_blank"><font color="#EE6252"><?php echo Url::log($logid); ?></font></a><br>
<i class="fa fa-bullhorn"></i> 版权声明：若无特殊注明，本文皆为《 <a href="/"><?php echo $blogname; ?></a>》原创，转载请保留文章出处。
</div>

<div class="action-share bdsharebuttonbox"><?php echo get_share(); ?></div>
</article> 
<?php if(!empty($ad_page_down)):echo $ad_page_down;endif;?>
	<div class="article_related"><?php doAction('log_related', $logData); ?></div>
	
			<div class="article_post_comment" id="comment-place">
				<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
			</div>
			<a name="comments"></a>
			<?php 
				echo '<h3 class="comment-header">大佬们的评论<b>（'.$comnum.'）</b></h3>';
				echo '<div class="article_comment_list">';
			?>
			<?php blog_comments($comments,$comnum); ?>
			<?php
				echo '</div>';
			?>
			


</div> </div><?php include View::getView('side_page'); ?>
</div>
<?php
 include View::getView('footer');
?>
