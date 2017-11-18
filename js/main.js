/*
if( !window.console ){
    window.console = {
        log: function(){}
    }
}
 * jsui
 * ====================================================
*/
jsui.bd = $('body');

if( $('.widget-nav').length>0){
    $('.widget-nav li').each(function(e){
        $(this).hover(function(){
            $(this).addClass('active').siblings().removeClass('active');
            $('.widget-navcontent .item:eq('+e+')').addClass('active').siblings().removeClass('active');
        })
    })
}


/* 
 * rollbar
 * ====================================================
*/
jsui.rb_comment = ''
if ($('.comment-open').length) {
    jsui.rb_comment = "<li><a href=\"javascript:(scrollTo('#comment-place',-15));\"><i class=\"fa fa-comments\"></i></a><h6>去评论<i></i></h6></li>"
}

jsui.bd.append('\
    <div class="m-mask"></div>\
    <div class="rollbar"><ul>'
    +jsui.rb_comment+
    '<li><a href="javascript:(scrollTo());"><i class="fa fa-angle-up"></i></a><h6>去顶部<i></i></h6></li>\
    </ul></div>\
')

var _wid = $(window).width();
$(window).resize(function(event) {
    _wid = $(window).width();
});

$(window).load(function(){
    $(".widget_ui_comments li,.focusbox .most-comment-posts ul li,.excerpt h2,.widget_ui_posts li").hover(function() {
		$(this).stop().animate({
			marginLeft: "12px"
		}, 400);
	}, function() {
		$(this).stop().animate({
			marginLeft: "0px"
		}, 400);
	});
});

var scroller = $('.rollbar');
var _fix = jsui.is_fix==2 ? true : false;
$(window).scroll(function() {
    var h = document.documentElement.scrollTop + document.body.scrollTop;

    if(_fix&& h > 21 && _wid > 720 ){
        jsui.bd.addClass('nav-fixed');
    }else{
        jsui.bd.removeClass('nav-fixed');
    }

    h > 200 ? scroller.fadeIn() : scroller.fadeOut();
})

/* 
 * sign
 * ====================================================
*/
if (_wid>720 && !jsui.bd.hasClass('logged-in')) {
    require(['signpop'], function(signpop) {
        signpop.init();
    })
}

/*二级导航下拉框
 *
 */
 	$(".site-navbar li ul").prev("a").each(function() {
		ls_href = $(this).html();
		$(this).html(ls_href + ' <i class="fa fa-angle-down"></i>');
	});

	
/*
 * 单页面标题框
*/
	$(".pagemenu li").each(function() {
		var a = $(".content h1.article-title").text();
		if ($(this).children("a").text() == a) {
			$(this).addClass("active");
		}
	});

	/*
	*搜索框
	*/
		$(".search-show").bind("click", function() {
		var a = $(".site-search");
		$(this).parent().toggleClass("active");
		$(this).find(".fa").toggleClass("fa-remove");
		a.toggleClass("active");
		if (a.hasClass("active")) {
			a.find("input").focus();
		}
	});
/* 
 * phone
 * ====================================================
*/

jsui.bd.append( $('.site-navbar').clone().attr('class', 'm-navbar') )

$('.m-icon-nav').on('click', function(){
	$(this).show()
    jsui.bd.addClass('m-nav-show')

    $('.m-mask').show()

    jsui.bd.removeClass('search-on')
    $('.search-show .fa').removeClass('fa-remove') 
})

$('.m-mask').on('click', function(){
    $(this).hide()
    jsui.bd.removeClass('m-nav-show')
})


/* 
 * single
 * ====================================================
*/

var fix = $('.widget_fix');
if (_wid>1024 && fix.length) {


side_high = fix.height();
side_top = fix.offset().top;
$(window).scroll(function () {
	var scrollTop = $(window).scrollTop();
	var a = $(".widget.widget_fix");
	var mh = $('.content').height();
//如果距离顶部的距离小于浏览器滚动的距离，则添加fixed属性。
if (side_top < scrollTop){
	 a.addClass("affix");
	 if(scrollTop + side_high > mh){
		a.css('top',mh-scrollTop-side_high+'px');	
	}else{
		a.css('top','0px');	
	}	
}
//否则清除fixed的css属性
else {a.removeClass("affix");
	  a.css("top","inherit");
	  };
});



}

/* 友情链接 favorite图标*/
$('.plinks a').each(function(){
    //var imgSrc = $(this).attr('href').substr(7).replace('/','');
    var imgSrc = $(this).attr('href');
    $(this).prepend( '<img src="'+jsui.uri + "favicon/fav.php?url=" + imgSrc +'">' );
})

function huoquqq() {
	$('#loging').html('<img src="'+jsui.uri+'/images/loading.gif"><a style="font-size:12px;margin-left:5px;">\u6b63\u5728\u83b7\u53d6QQ\u4fe1\u606f..</a>');
	var urls = window.location.href;
	$.ajax({
		url: urls,
		type: "POST",
		data: {
			"qq": $('#qqnum').val()
		},
		dataType: "html",
		success: function(c) {
			var josn = eval("" + c.split('@@')[1].split('@@')[0] + "");
			$('#loging').html(" ");
			$('#comname').val(josn.comname);
			$('#commail').val(josn.commail);
			$('#comurl').val(josn.comurl);
			$(".none_user").html(josn.comname);
			$('#toux').attr("src", josn.toux);
		}
	});
}

/* 
 * phone
 * ====================================================
*/
function pjax_done(){
	
/*
 * 表情
 */ 
	var m = $(".comment_face_btn");
	var n = $("#Face");
	//n.hide();
	m.click(function() {
		n.slideToggle();
	});
	$("#Face a").bind({
		"click": function() {
			var a = $(this).attr("data-title");
				obj = $("#comment").get(0);
			if (document.selection) {
				obj.focus();
				var b = document.selection.createRange();
				b.text = a;
			} else {
				if (typeof obj.selectionStart === "number" && typeof obj.selectionEnd === "number") {
					obj.focus();
					var c = obj.selectionStart;
					var d = obj.selectionEnd;
					var e = obj.value;
					obj.value = e.substring(0, c) + a + e.substring(d, e.length)
				} else {
					obj.value += a;
				}
			}
		}
	});
	
/*
 * User用户
 */
if($("#setting").length){
	$("head").append("<link>");
	css = $("head").children(":last");
	css.attr({
		rel: "stylesheet",
		type: "text/css",
		href: "./content/templates/emlog_dux/option/set.css"
	});
}

if ($(".container-user").length > 0) {
	$("head").append("<link>");
	css = $("head").children(":last");
	css.attr({
		rel: "stylesheet",
		type: "text/css",
		href: "./content/templates/emlog_dux/style/user.css"
	});
	//var action1 = window.location.;


	$('.usermenu li').each(function() {
		var nr = $(".useridx").html()
		if($(this).hasClass("usermenu-" + nr)){
			$(this).addClass("active");
		}
	})
}


/* 
 * highlight code
 * ====================================================
*/
if( $('pre').length ){
    require(['prettify'], function(prettify) {
        prettyPrint()
    })
}

/* 
 * lazyload
 * ====================================================
 */
if(Number(jsui.lazyload)){
	require(['lazyload'], function() {
		$('.focusbox-wrapper img')["lazyload"]({
			threshold :400,
			event: 'scrollstop'
		})

		$('.row-fluid img')["lazyload"]({
			threshold :400,
			event: 'scrollstop'
		})

		$('.widget img')["lazyload"]({
			threshold :400,
			event: 'scrollstop'
		})
		
		$('.container img')["lazyload"]({
			threshold :400,
			event: 'scrollstop'
		})
		})
}/*
  * 百度分享 share
  *
  */
  window._bd_share_config = {
      common: {
          "bdText": "",
          "bdMini": "2",
          "bdDesc": '很不错的文章，分享给大家！',
          "bdMiniList": false,
          "bdPic": $('.article_content img:first') ? $('.article-content img:first').attr('src') : '',
          "bdStyle": "0"
      },
      share: [{
          // "bdSize": "24",
          bdCustomStyle: jsui.uri + '/style/share.css'
      }],
      image: {
                tag: 'bdshare',
                "viewList": ["qzone", "tsina", "weixin", "tqq", "sqq", "renren", "douban"],
                "viewText": " ",
                "viewSize": "16"
        }

  }
  with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion=' + ~(-new Date() / 36e5)];

if(Number(jsui.iasnum)){
	require(['ias.min'],function(ias){
	$.ias({
        triggerPageThreshold: jsui.iasnum?Number(jsui.iasnum)+1:5,
        history: false,
        container : '.content',
        item: '.excerpt',
        pagination: '.pagenavi',
        next: '.nextpages',
        loader: '<div class="pagination-loading"><img src="'+jsui.uri+'/images/loading.gif"><a>\u6b63\u5728\u52a0\u8f7d\u002e\u002e\u002e</a></div>',
        trigger: 'More',
        onRenderComplete: function() {
        	pjax_done();
          }  
	    });
})
}
$("#commentform").submit(function() {
        var a = $("#commentform").serialize();
        $(".comment_info").html('<img src="'+jsui.uri+'/images/loading.gif">');
        $.ajax({
            type: 'POST',
            url: $("#commentform").attr("action"),
            data:a,
            success: function(a){
				//评论失败：您提交评论的速度太快了，请稍后再发表评论
                var c = /<div class=\"main\">[\r\n]*<p>(.*?)<\/p>/i;
                c.test(a) ? ($(".comment_info").html(a.match(c)[1]).show().fadeIn(2500)) : (c = $("input[name=pid]").val(), cancelReply(), $("[name=comment]").val(""), $(".article_comment_list").html($(a).find(".article_comment_list").html()), 0 != c ? (a = window.opera ? "CSS1Compat" == document.compatMode ? $("html") : $("body") : $("html,body"), a.animate({
                    scrollTop: $("#comment-" + c).offset().top - 250
                }, "normal", function() {
                $(".comment_info").html("Ctrl+Enter快速提交").fadeIn(2500);
                })) : (a = window.opera ? "CSS1Compat" == document.compatMode ? $("html") : $("body") : $("html,body"), a.animate({
                    scrollTop: $(".article_comment_list").offset().top - 250
                }, "normal", function() {
                    $(".comment_info").html("Ctrl+Enter快速提交").fadeIn(2500);
                })));
                pjax_done();
            }
        })
        return !1
    });
$("#comment").focus(function(){
	$(".comment_info").html("Ctrl+Enter快速提交").fadeIn(2500);
})

}
pjax_done()
if(document.body.offsetWidth>=600 && jsui.is_pjax==1){
	require(['pjax'], function(pjax) {
	$(document).pjax('a[target!=_blank]', '.pjax', {fragment:'.pjax', timeout:8000});
	$(document).on('submit', 'form', function(event) {
		$.pjax.submit(event, '.content-wrap', {
			fragment: '.content-wrap',
			timeout: 6000
		})
	});
	$(document).on('pjax:send', function() { //pjax链接点击后显示加载动画；
    $(".pjax_loading").css("display", "block");});
	$(document).on('pjax:complete', function() { //pjax链接加载完成后隐藏加载动画；
    $(".pjax_loading").css("display", "none");
    pjax_done();
	if($(".article-title").length){
		$(".container")["addClass"]("single");
	}else{
		$(".container")["removeClass"]("single")
	}
	if($(".user-main").length || $("#setting").length){
		$(".sidebar").css("display", "none");
	}else{
		$(".sidebar").css("display", "block");
	}
	if($(".focusbox-wrapper").length){
		$(".focusbox-wrapper").css("display", "none");
	}
    })
});
}
/* functions
 * ====================================================
 */
function scrollTo(name, add, speed) {
    if (!speed) speed = 300
    if (!name) {
        $('html,body').animate({
            scrollTop: 0
        }, speed)
    } else {
        if ($(name).length > 0) {
            $('html,body').animate({
                scrollTop: $(name).offset().top + (add || 0)
            }, speed)
        }
    }
}

$.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
function video_ok(){
    $('.article-content embed, .article-content video, .article-content iframe').each(function(){
        var w = $(this).attr('width'),
            h = $(this).attr('height')
        if( h ){
            $(this).css('height', $(this).width()/(w/h))
        }
    })
}
video_ok();
 /** ToolTip.js **/
$(function() {
	$('a').not('.close_login_box').each(function(b) {
		if (this.title) {
			var c = this.title;
			var a = 30;
			$(this).mouseover(function(d) {
				this.title = "";
				$("body").append('<div id="tooltip">' + c + "</div>");
				$("#tooltip").css({
					left: (d.pageX + a) + "px",
					top: d.pageY + "px",
					opacity: "0.8"
				}).show(250)
			}).mouseout(function() {
				this.title = c;
				$("#tooltip").remove()
			}).mousemove(function(d) {
				$("#tooltip").css({
					left: (d.pageX + a) + "px",
					top: d.pageY + "px"
				})
			})
		}
	})
		$('span').not('.close_login_box').each(function(b) {
		if (this.title) {
			var c = this.title;
			var a = 30;
			$(this).mouseover(function(d) {
				this.title = "";
				$("body").append('<div id="tooltip">' + c + "</div>");
				$("#tooltip").css({
					left: (d.pageX + a) + "px",
					top: d.pageY + "px",
					opacity: "0.8"
				}).show(250)
			}).mouseout(function() {
				this.title = c;
				$("#tooltip").remove()
			}).mousemove(function(d) {
				$("#tooltip").css({
					left: (d.pageX + a) + "px",
					top: d.pageY + "px"
				})
			})
		}
	})
});