<?php 
/**
 * 自建页面模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

<div class="single single-post postid- single-format-standard nav_fixed">
<div class="container container-page">
	<div class="pageside">
	<div class="pagemenus">
		<ul class="pagemenu">
			<?php 
			//global $side_title;
			$side_title = unserialize($side_title);
			//global $side_url;
			$side_url = unserialize($side_url);
				for($i=1;$i<=20;$i++){
					if($side_title[$i]==""){echo "</ul>";}elseif($side_title[$i]=="-"){
						echo '</ul><ul class="pagemenu">';
					}else{
						$url=$side_url[$i];
						$alinks=$side_title[$i];
						echo "<li><a href='{$url}'>{$alinks}</a></li>";

					}
				}

			?>
	</div>
</div>	<div class="content">
				<header class="article-header">
			<h1 class="article-title"><?php echo $log_title; ?></h1>
		</header>
		<div class="page_content_container">
                <header class="page_header"></header>
                <article class="page_content article_content">
                                    </article>

                <div class="page_archive">
                    <?php echo displayRecord1();?>             </div>

            </div>
		<article class="article-content"><?php echo $log_content; ?>
					</article>
		

			<?php 
			if(isShowComment($comnum)) {
				echo "</br></br></br></br></br>";}
			?>

			<div class="article_post_comment" id="comment-place">

				<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
			</div>
			<a name="comments"></a>
			<?php 
			if(isShowComment($comnum)) {
				echo '<h3 class="comment-header">大佬们的评论<b>（'.$comnum.'）</b></h3>';
				echo '<div class="article_comment_list">';}
			?>
			<?php blog_comments($comments,$comnum); ?>
			<?php
			if(isShowComment($comnum)) {
				echo '</div>';}
			?>
	</div>
</div>
</div>
<?php
 include View::getView('footer');
?>
