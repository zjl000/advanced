<?php 
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
?>
<div id="wp" class="wp cl">
	<style>
		.memoirs-recom { width: 100%; background-color: #f6f6f6; border-bottom: 1px solid #ddd; }
		.memoirs-recom .m-recom-auto { width: 1100px; margin: 0 auto; }
		.m-recom-auto .m-nav { float: left; margin-left: 10px; }
		.m-nav .m-nav-li { float: left; height: 54px; line-height: 54px; font-size: 16px; margin-left: 2px; }
		.m-nav .current { margin-left: 50px; color: #ff9306; }
		.m-nav .m-nav-li a { color: #666; }
		.m-nav .m-nav-li a:hover { color: #ff9306; text-decoration: none; }
		.m-recom-auto .m-search { float: right; margin-right: 10px; margin-top: 8px; border: 1px solid #ccc; position: relative; }
		.m-search .m-search-input { border: 1px solid #eee; width: 280px; padding: 7px 8px; font-size: 14px; color: #666; margin: 0; }
		.m-search .m-search-a { display: block; width: 32px; height: 37px; background: url('../web/images/m_search.png') no-repeat 4px 8px; position: absolute; right: 0; top: 0; }
		.m-search .m-search-a:hover { background-position: 4px -40px; }
	</style>

	<div class="memoirs-recom">
		<div class="m-recom-auto cl">
			<ul class="m-nav">
				<li class="m-nav-li"><a href="<?= Url::to(['recommand/index']); ?>">推荐</a></li>
				<li class="m-nav-li current">书库</li>
			</ul>
			<form id="search" class="m-search" action="<?= Url::to(['book/index']); ?>" method="post">
				<input name="_csrf" type="hidden" id="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
				<input class="m-search-input" type="text" name="m-search" placeholder="搜索你喜欢的作者或书名..." />
				<a class="m-search-a" href="javascript:document.getElementById('search').submit();"></a>
			</form>
		</div>
	</div>

	<link rel="stylesheet" type="text/css" href="../web/css/books.css" />
	<script src="../web/js/jquery-1.8.3.min.js" type="text/javascript"></script>
	
	<!-- 设置搜索条滚动固定 -->
	<script>
		$(function(){
			//获取固定div到顶部距离
			var d = jQuery('.memoirs-recom').offset().top;
			
			//设置滚动事件
			jQuery(window).scroll(function(){
				//设置鼠标滚动距离（兼容多种浏览器）
				var s = document.documentElement.scrollTop || document.body.scrollTop;
				if(s > parseInt(d)){
					jQuery('.memoirs-recom').css({'position':'fixed', 'top':0, 'z-index':1});
				}else{
					jQuery('.memoirs-recom').css('position','static');
				}
			})
		})
	</script>

	<!--main start-->
	<div class="tag-box cl">
		<div id="list" class="gl_nav">
			<span>全部作品分类:</span>
			<div class="cl"></div>
		</div>
	
		<!-- 筛选 -->
		<form action="<?= Url::to(['book/index']); ?>" method="post">
			<input name="_csrf" type="hidden" id="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
			<div class="gl_wrap" id="status">
				<input type="hidden" name="status" value="" />
				<h3>状态</h3>
				<ol>
					<li>
						<a class="on" href="javascript:;" data-vid="">全部</a>
					</li>						
					<li>
						<a  href="javascript:;" data-vid="1">随笔</a>
					</li>
					<li>
						<a  href="javascript:;" data-vid="0">回忆录</a>
					</li>
				</ol>
				<div class="cl"></div>
			</div>

			<div class="gl_wrap tagid" id="trade">
				<input type="hidden" name="tagid0" value="" />
				<h3>行业</h3>
				<ol>
					<li>
						<a class="on" href="javascript:;" data-vid="">全部</a>
					</li>
					<?php foreach($tag1 as $trade){ ?>
						<li>
							<a  href="javascript:;" data-vid="<?=$trade['tagid'];?>"><?=$trade['name'];?></a> 
						</li>
					<?php } ?>
				</ol>
				<span class="sp_toggle">
					<a class="more_selector" href="javascript:void(0);">更多</a>
				</span>
				<div class="cl"></div>
			</div>

			<div class="gl_wrap tagid" id="exp">
				<input type="hidden" name="tagid1" value="" />
				<h3>经历</h3>
				<ol>
					<li>
						<a class="on" href="javascript:;" data-vid="">全部</a>
					</li>
					<?php foreach($tag2 as $exp){ ?>
						<li>
							<a  href="javascript:;" data-vid="<?=$exp['tagid'];?>"><?=$exp['name'];?></a>
						</li>
					<?php } ?>
				</ol>
				<span class="sp_toggle">
					<a class="more_selector" href="javascript:void(0);">更多</a>
				</span>
				<div class="cl"></div>
			</div>

			<div class="m-find">
				<button type="submit" id="search">开始查找</button>
			</div>
		</form>

		<script>
			jQuery.noConflict();
			jQuery(".more_selector").click(function(){
				if(jQuery(this).hasClass("sp_toggle")){
					jQuery(this).removeClass('sp_toggle').closest('span').prev('ol').css('height','30px');
				} else {
					jQuery(this).addClass('sp_toggle').closest('span').prev('ol').css('height','auto');
				}
			}); 
			jQuery('.tagid ol').find('a').each(function(){
				jQuery(this).click(function(){
					jQuery(this).parents('.gl_wrap ol').find('a').removeClass('on');
					jQuery(this).addClass('on');	
					jQuery(this).parents('.gl_wrap').find('input').val(jQuery(this).attr('data-vid'));
				});
			});
			jQuery('#status ol').find('a').each(function(){					
				jQuery(this).click(function(){
					jQuery(this).parents('.gl_wrap ol').find('a').removeClass('on');
					jQuery(this).addClass('on');	
					jQuery(this).parents('.gl_wrap').find('input').val(jQuery(this).attr('data-vid'));
				});
			});	

			//筛选后，跳转页面选中状态	
			//状态
			jQuery("#status ol").find('a').each(function(){
			var s = jQuery(this).attr('data-vid');	
			if(s == '<?= $status ?>'){
					jQuery(this).parents('.gl_wrap ol').find('a').removeClass('on');
					jQuery(this).addClass('on');	
					jQuery(this).parents('.gl_wrap').find('input').val(<?= $status ?>);
				}
			})
			
			//行业
			jQuery("#trade ol").find('a').each(function(){
				var t = jQuery(this).attr('data-vid');
				if(t == '<?= $tagid0; ?>'){
					jQuery(this).parents('.gl_wrap ol').find('a').removeClass('on');
					jQuery(this).addClass('on');	
					jQuery(this).parents('.gl_wrap').find('input').val(<?= $tagid0; ?>);
				}
			})
			
    		//经历
    		jQuery("#exp ol").find('a').each(function(){
				var e = jQuery(this).attr('data-vid');
				if(e == '<?= $tagid1; ?>'){
					jQuery(this).parents('.gl_wrap ol').find('a').removeClass('on');
					jQuery(this).addClass('on');	
					jQuery(this).parents('.gl_wrap').find('input').val(<?= $tagid1; ?>);
				}
			})

			//搜索后保留搜索条件
			jQuery(".m-search-input").val('<?= $search; ?>');		
		</script>

		<div class="msg_number">
			<!-- 是否有搜索条件 -->
			<?php if($status != '' || !empty($tagid0) || !empty($tagid1) || !empty($search)){ ?>
				<p>共找到<span class="number_color"><?= $count; ?></span>部作品</p>
			<?php }else{ ?>
				<p>共找到<span class="number_color"><?= $pagination->totalCount;?></span>部作品</p>
			<?php } ?>
		</div>
	</div>

	<div class="m-box cl">
		<div class="m-list">
			<?php foreach($data as $book){ ?>
				<div class="m-detail">
					<input type="hidden" name="bookid" value="<?= $book['bookid'] ?>">
					<div class="book-info">
						<a class="book-title" target="_blank" href="<?= Url::to(['read/index', 'id'=>$book['bookid']]); ?>"><?= $book['bookname']; ?></a>
						<p>
							<span class="book-author">作者：<a href="other/home.php?mod=space&amp;uid=324" target="_blank"><?= $book['username']; ?></a></span><span class="book-post"></span>		
						</p>
						<p>
							<span><?= $book['viewnum']; ?>人正在阅读</span><span class="new-chapter"><?= date('Y-m-d',$book['lasttime']); ?></span>
						</p>
						<p>标签：<?= $book['tag']; ?></p>
					</div>
					<div class="book-txt">
						<div class="book-txt-l">
							<p><?= mb_substr($book['introduction'], 0, 91, 'utf-8'); ?>&nbsp;...</p>
						</div>
					</div>
					<div class="book-wrap">
						<a class="book-img" href="<?= Url::to(['read/index', 'id'=>$book['bookid']]); ?>" target="_blank">
							<img width="176" height="234" src="../web/images/<?= $book['cover']; ?>" />
						</a>
						<a class="read-btn" href="<?= Url::to(['read/index', 'id'=>$book['bookid']]); ?>" target="_blank">阅&nbsp;&nbsp;读</a>
					</div>
				</div>
			<?php } ?>
		</div>

		<!-- 单击阅读后，对应的阅读量+1 -->
		<script>
			jQuery(function(){
				//将阅读按钮和书籍标题绑定同一单击事件
				jQuery('.book-img, .read-btn, .book-title').click(function(){
					var bookid = jQuery(this).parents('.m-detail').find('input').val();
					var url = 'index.php?r=recommand/update';
					// alert(bookid);
					jQuery.ajax({
						url:url,
						type:'get',
						data:{bookid:bookid},
						success:function(data){
							if(data){
								// location = 'index.php?r=read/index&id='+bookid;
							}	
						}
					})
				})
			})
		</script>

		<style>
			.m-box .page { width: 980px; margin: 0 auto; }
			.m-box .page .pg{width:100%; }
			.m-box .page .pg ul{float:right;}
			.m-box .page .pg li{float:left; margin-right:5px;}
		</style>

		<div class="page">
			<div class="pg">
				<?=LinkPager::widget(['pagination'=>$pagination])?>
			</div>
		</div>
	
	</div>
	<!--main end-->	
</div>