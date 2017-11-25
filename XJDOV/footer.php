<?php
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<footer class="footer">
<div class="container">
<div class="copyright"><?php echo "在线人数：".$users_online."人";?><a href="https://jq.qq.com/?_wv=1027&k=4BSdU7C">&nbsp;</a>&nbsp;|&nbsp;<a href="http://liuniangekm.cn" title="小俊大帅比" target="_blank">小俊网络</a>&nbsp;|&nbsp;<script src="https://s11.cnzz.com/z_stat.php?id=1256655437&web_id=1256655437" language="JavaScript"></script>&nbsp;|&nbsp;<a href="http://www.xjdog.cn/sitemap.xml" target="_blank" rel="sitemap">XML</a>&nbsp;|&nbsp;<a href="http://www.xjdog.cn/map.html" target="_blank" rel="sitemap">网站地图</a></br></br><img src="http://www.xjdog.cn/tp/icp.png" class="footer-icon">&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank">黔ICP备17003671号-1</a>&nbsp;&nbsp;&nbsp;&nbsp;<br><br><img src="http://www.xjdog.cn/tp/batb.png" class="footer-icon">  <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=52010202000353">贵公网安备 52010202000353号</a></div>
<?php echo $footer_info; ?>
</footer>
<?php doAction('index_footer'); ?>
</div>
<div class="pjax_loading"></div>
<div class="pjax_loading1"></div>
</div>
<script src="/content/templates/XJDOV/js/xjbk.js" data-no-instant></script>
<script>
POWERMODE.colorful = true; // make power mode colorful
POWERMODE.shake = false; // turn off shake
document.body.addEventListener('input', POWERMODE);
</script>
</body>

<script>
window.jsui={
	www: '<?php echo BLOG_URL; ?>',
	uri: '<?php echo TEMPLATE_URL; ?>',
	ver: '4.5.0',
	logocode: '<?php echo Option::get('login_code');?>',
	is_fix:'<?php echo $navhide;?>',
	is_pjax:'<?php echo $pjax;?>',
	iasnum:'<?php echo $down_next; ?>',
	lazyload:'<?php echo $webcompress; ?>',
};
</script>

<script type='text/javascript' color='50, 205, 50' zIndex='-1' opacity='1' count='99' src="/content/templates/XJDOV/js/canvas.js"></script>
<script type='text/javascript' src='<?php echo TEMPLATE_URL; ?>js/loader.js?ver=4.5.1'></script>
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
}?>