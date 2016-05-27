//设置用户评论
jQuery(function(){
	//评论部分高度
	jQuery('.c_bd').css({height:jQuery(window).height()-100});

	//评论输入框，设置按键抬起事件
	jQuery('#content').keyup(function(event){
		//判断输入字数
		if(jQuery("#content").val().length<=500){		
			jQuery('.size-leave').html("还能输入"+parseInt(500-jQuery("#content").val().length)+"字");
		}else{
			jQuery('.size-leave').html("<font color='red'>你已经超过"+parseInt(jQuery("#content").val().length-500)+"字</font>");
		}
	})

	//设置单击事件
	jQuery('.c_submit').click(function(){
		//如字数超过500，则阻止提交
		if(jQuery("#content").val().length>500){
			//设置输入框背景为粉红色
			jQuery("#content").css({background:'pink'});
			//设置单次计时，1000ms后背景为白色
			setTimeout(function(){
				jQuery("#content").css({background:'#fff'});
			},1000);			
			//光标聚焦到输入框
			jQuery("#content").focus();
			//阻止提交
			return false;
		}

		//获取参数
		var _csrf = jQuery('#_csrf').val();//csrf验证
		var bookid = jQuery('#bookid').val();//书籍ID
		var username = jQuery('#username').val();//当前用户名
		var url = 'index.php?r=read/reply';//URL跳转
		var content = jQuery("#content").val();//用户输入的评论内容

		//判断评论内容是否为空
		if(content == ''){
			//弹出框
			jQuery('body').append("<div class='pop_black'>评论内容不能为空！</div>");

			setTimeout(function(){
				jQuery('.pop_black').fadeOut('slow');
			},'2000');
		}else{
			//使用ajax处理
			jQuery.post(url,{content:content, _csrf:_csrf, bookid:bookid},function(data){
				if(data){
						//解析内容中的表情
						var m = data.message; //评论内容
						var p = /\[em:(\d+):\]/g; //正则匹配
						//定义变量
						var arr;
						var num = [];
						//内容匹配正则，并循环插入到num数组变量
						while((arr = p.exec(m)) !=null){ 
							num.push(arr[1]);
						}
						//判断num数组是否为空，若为空，则评论内容没有插入表情
						if(num.length != 0){
							for(i=0; i<num.length; i++){
								res = m.replace(p,'<img src="images/smiley/'+num[i]+'.gif" />');
							}
						}else{
							res = m;
						}
						// alert(num);die;
						
						//拼接返回过来的评论内容
						var str="<li class='J_ItemLi'>";

						str+="<div class='head-pic2'>";

						str+="<a href='home.php?mod=space&uid="+data.uid+"&do=profile' target='_blank'><img src='other/avatar.php' width=60 height=60 /></a>";

						str+="<a class='c_author' href='home.php?mod=space&uid="+data.uid+"&do=profile' target='_blank'>"+username+"</a>";

						str+="</div>";

						str+="<p class='c_desc'>"+res+"</p>";

						str+="<p class='c_act'>";

						str+="<span>刚刚 发表</span>";								

						str+="<a href='javascript:;' onclick='reply(this)'>回复</a>";

						//str+="<a href='#'>举报</a>";

						str+="<a href='javascript:;' onclick='delreply(this)' key='"+data.replyid+"'>删除</a>";

						str+="<input type='hidden' name='uid' value='"+data.uid+"' />";

						str+="<input type='hidden' name='bookid' value='"+data.bookid+"' />";

						str+="<input type='hidden' name='author' value='"+data.author+"' />";

						str+="</p>";

						str+="<div class='reply-box-wrap'></div>";

						str+="</li>";
						//内部前入
						jQuery('.c_list').prepend(str);
						//设置输入框为空
						jQuery('#content').val('');
						//设置提示信息
						jQuery('.size-leave').html("还能输入500字");
						//评论数量+1
						jQuery('.c_size').find('em').html(parseInt(jQuery('.c_size').find('em').html())+1);
						//弹出框
						jQuery('body').append("<div class='pop_black'>发表成功</div>");

				}		

			},'json');
			
			//设置单次计时，将发表成功弹出框淡出
			setTimeout(function(){		
				jQuery('.pop_black').fadeOut('slow');
			},'2000');
		}	
	})

	//评论框淡出
	jQuery('.c_close').click(function(){
		jQuery('#comment_bg').fadeOut('slow');
		jQuery('.comment_box').fadeOut('slow');
	})
})

//评论框淡入
function comment(){
	jQuery('#comment_bg').fadeIn('slow');
	jQuery('.comment_box').fadeIn('slow');
}

//删除评论
function delreply(obj){
	//获取对应的评论信息ID
	var replyid = jQuery(obj).attr('key');
	//移除父级li标签
	jQuery(obj).parents('li').remove();
	//评论数量-1
	jQuery('.c_size').find('em').html(parseInt(jQuery('.c_size').find('em').html())-1);

	var _csrf = jQuery('#_csrf').val();//csrf验证
	var url = 'index.php?r=read/delreply';//URL跳转

	//ajax传值处理
	jQuery.post(url,{replyid:replyid, _csrf:_csrf},function(data){
		jQuery('body').append("<div class='pop_black'>删除成功</div>");
	});

	setTimeout(function(){
		jQuery('.pop_black').fadeOut('slow');
	},'2000');

}

//设置回复框
function reply(obj){
	//移除c_list下所有的回复框
	jQuery('.c_list').find('.reply-box').remove();
	//获取被回复的用户名
	var username = jQuery(obj).parents('.J_ItemLi').find('.c_author').html();
	//判断回复框是否为空
	if(jQuery(obj).parents('.c_act').next('.reply-box-wrap').html()==''){
		//拼接
		var str="<div class='reply-box'>";

			str+="<i class='angle'></i>";

			str+="<form>"										

			//str+="<div class='r_emotion'><a class='show-emotion' href='javascript:;'></a></div>";


			str+="<div class='r_content'>";

			str+="<div class='contentwrap'>";

			str+="<textarea placeholder='回复："+username+"' name='content' id='message'></textarea>";

			str+="</div>";

			str+="<div class='bottombar'>";

			str+="<p class='size-leave size-leave2'>还能输入500字</p>";

			str+="<div class='r_emotion'><a id='comment_face2' class='show-emotion' onclick='showFace(this.id, \"message\");return false;' href='javascript:;' title='插入表情'></a></div>";

			str+="<p class='btn'>";

			str+="<a class='J_Back ui-default' onclick='back(this)'>取消</a>";

			str+="<a class='J_Send replaybtn' onclick='sendreply(this)'>回复</a>";

			str+="</p>";

			str+="</div>";

			str+="</div>";

			str+="</form>";

			str+="</div>";
			//插入拼接内容
			jQuery(obj).parents('.c_act').next('.reply-box-wrap').append(str);
			//为输入框设置按键抬起事件
			jQuery('#message').keyup(function(event){
				//判断输入框字数
				if(jQuery("#message").val().length<=500){		
					jQuery('.size-leave2').html("还能输入"+parseInt(500-jQuery("#message").val().length)+"字");
				}else{
					jQuery('.size-leave2').html("<font color='red'>你已经超过"+parseInt(jQuery("#message").val().length-500)+"字</font>");
				}
			})
	}else{
		jQuery(obj).parents('.c_act').next('.reply-box-wrap').children('.reply-box').remove();
	}
}

//取消回复框
function back(obj){
	jQuery(obj).parents('.reply-box').remove();
}

//发送回复
function sendreply(obj){
	//如果输入框字数超过500，则阻止提交
	if(jQuery("#message").val().length>500){
		jQuery("#message").css({background:'pink'});

		setTimeout(function(){
			jQuery("#message").css({background:'#fff'});
		},1000);			

		jQuery("#message").focus();
		return false;
	}

	
	//获取参数
	var _csrf = jQuery('#_csrf').val();//csrf验证
	var buid = jQuery('#buid').val(); //当前书籍的作者ID
	var uname = jQuery('#username').val();//当前回复用户名
	var uid = jQuery(obj).parents('.reply-box-wrap').prev('.c_act').find('input[name="uid"]').val();//被回复的用户ID
	var username = jQuery(obj).parents('.J_ItemLi').find('.c_author').html();//被回复的用户名
	var bookid = jQuery(obj).parents('.reply-box-wrap').prev('.c_act').find('input[name="bookid"]').val();//书籍ID
	var author = jQuery(obj).parents('.reply-box-wrap').prev('.c_act').find('input[name="author"]').val();//作者名
	var message = jQuery(obj).parents('.bottombar').prev('.contentwrap').children('#message').val();//获取输入内容
	var url = 'index.php?r=read/sendreply';//URL跳转

	//判断回复内容是否为空
	if(message == ''){
		//弹出框
		jQuery('body').append("<div class='pop_black'>回复内容不能为空！</div>");

		setTimeout(function(){
			jQuery('.pop_black').fadeOut('slow');
		},'2000');
	}else{
		//ajax传值
		jQuery.post(url,{_csrf:_csrf, uid:uid, bookid:bookid, author:author, message:message},function(data){
			if(data){
				//解析内容中的表情
				var m = data.message;//传递过来的内容
				var p = /\[em:(\d+):\]/g; //正则
				var arr;
				var num = [];
				//内容匹配正则，并循环插入到num数组变量
				while((arr = p.exec(m)) !=null){
					num.push(arr[1]);
				}
				//判断num数组是否为空
				if(num.length != 0){
					for(i=0; i<num.length; i++){
						res = m.replace(p,'<img src="images/smiley/'+num[i]+'.gif" />');
					}
				}else{
					res = m;
				}

				//拼接
				var str="<li class='J_ItemLi'>";

					str+="<div class='head-pic2'>";

					str+="<a href='home.php?mod=space&uid="+data.uid+"&do=profile' target='_blank'><img src='other/avatar.php' width=60 height=60 /></a>";

					str+="<a class='c_author' href='home.php?mod=space&uid="+data.uid+"&do=profile' target='_blank'>"+uname+"</a>";

					str+="</div>";

					str+="<p class='c_desc'><span style='display: block;'>回复 <a style='color:#327d99' href='home.php?mod=space&uid="+uid+"'>"+username+"</a>：</span>"+res+"</p>";

					str+="<p class='c_act'>";

					str+="<span>刚刚 发表</span>";								

					str+="<a href='javascript:;' onclick='reply(this)'>回复</a>";

					//str+="<a href='#'>举报</a>";
					
					//判断评论用户ID是否与当前登陆用户ID相等，相等则显示删除按钮
					if(data.authorid == buid){
						str+="<a href='javascript:;' onclick='delreply(this)' key='"+data.replyid+"'>删除</a>";
					}

					str+="<input type='hidden' name='uid' value='"+data.uid+"' />";

					str+="<input type='hidden' name='bookid' value='"+data.bookid+"' />";

					str+="<input type='hidden' name='author' value='"+data.author+"' />";

					str+="</p>";

					str+="<div class='reply-box-wrap'></div>";

					str+="</li>";
					//内部前入
					jQuery('.c_list').prepend(str);
					//清空输入框
					jQuery('#message').val('');
					//隐藏回复框
					jQuery(obj).parents('.reply-box').hide();
					//评论数量+1
					jQuery('.c_size').find('em').html(parseInt(jQuery('.c_size').find('em').html())+1);
					//弹出框
					jQuery('body').append("<div class='pop_black'>回复成功</div>");
			}
		},'json');

		setTimeout(function(){
			jQuery('.pop_black').fadeOut('slow');
		},'2000');
	}	
}

//未登陆时，禁止回复
function r_nologin(){
	//弹出框
	jQuery('body').append("<div class='pop_black'>请登陆后操作！</div>");

	setTimeout(function(){
		jQuery('.pop_black').fadeOut('slow');
	},'2000');
}

//未登陆且登陆用户不是书籍作者时，禁止删除
function d_nologin(){
	//弹出框
	jQuery('body').append("<div class='pop_black'>无权限进行此操作！</div>");

	setTimeout(function(){
		jQuery('.pop_black').fadeOut('slow');
	},'2000');
}