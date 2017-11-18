<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

</section>
<footer class="footer">
<div class="container">
	<!--
		希望各位站长保留版权 您的支持就是我们最大的动力
		小俊博客:https://www.xjdog.cn/
	-->
	<p>Powered by <a href="http://www.emlog.net" title="骄傲的采用emlog系统">emlog</a> 
        <a href="https://www.xjdog.cn/" title="骄傲地采用XJDOV">©  XJDOV</a><br>
       <?php if(!empty($icp)):?><a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a><?php endif;?><?php echo $footer_info; ?>
	</p>
	<?php 
	 /*$databaseLink = MySql::getInstance();
$queryNum = $databaseLink->getQueryCount();
echo "<span>查询数据库：<font color=\"#FF3737\">".$queryNum."</font>次</span>";*/?>
</div>
</footer>
<?php doAction('index_footer'); ?>
</div>
<div class="pjax_loading"></div>
<div class="pjax_loading1"></div>
</div>
</body>


<script>
window.jsui={
	www: '<?php echo BLOG_URL; ?>',
	uri: '<?php echo TEMPLATE_URL; ?>',
	ver: '4.5.2',
	logocode: '<?php echo Option::get('login_code');?>',
	is_fix:'<?php echo $navhide;?>',
	is_pjax:'<?php echo $pjax;?>',
	iasnum:'<?php echo $down_next; ?>',
	lazyload:'<?php echo $webcompress; ?>',
};
</script>

<script type='text/javascript' src='<?php echo TEMPLATE_URL; ?>js/loader.js?ver=4.5.2'></script>

<?php echo bdPushData($logid);?>
</html>
<?php 
if($webcompress){
$echo = ob_get_contents(); //获取缓冲区内容
ob_clean(); //清楚缓冲区内容，不输出到页面
$placeholder = TEMPLATE_URL."images/lazyload.gif"; //占位符图片
$preg = "/<img(.*)? src(.*)>/i"; //匹配图片正则
$replaced = '<img \\1src="'.$placeholder.'" data-original\\2 >';
print preg_replace($preg, $replaced, $echo); //重新写入的缓冲区
ob_end_flush(); //将缓冲区输入到页面，并关闭缓存区
}