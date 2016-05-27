<?php use yii\helpers\Url; ?>
<div id="wp" class="wp cl">
	<style>
		#wp { width: 100%; }
		#bodyer { width: 100%; }
		.memoirs-bg { width: 100%; height: 578px; background: url('../web/images/memoirs_bg.png') no-repeat center top; position: relative; }
		.memoirs-bg .memoirs-des { position: absolute; left: 50%; margin-left: 160px; top: 120px; width: 460px; }
		.memoirs-des h1 { background: url('../web/images/arrow.png') no-repeat 0 6px; color: #000; font-size: 48px; font-weight: normal; padding-left: 10px; padding-bottom: 50px; }
		.memoirs-des p { line-height: 30px; padding-left: 10px; padding-bottom: 30px; font-size: 16px; color: #666; }
		.memoirs-des a { margin-left: 10px; display: block; height: 36px; line-height: 34px; width: 150px; text-align: center; background-color: #ff9306; margin-top: 30px; font-size: 18px; color: #fff; text-decoration: none; }
		.memoirs-des a:hover { background-color: #ffb306; }
	</style>

	<div id="bodyer">
		<div class="memoirs-bg">
			<div class="memoirs-des">
				<h1>回忆录</h1>
				<p>一段难以忘怀的经历，一部谆谆教诲的家书，一封诚挚<br/>感人的信函......</p>
				<p>生活当中总会有些事让人念念不忘。或是平淡质朴、或是精彩绝伦、或是温馨甜蜜、或是辛辣苦涩，虽然五味杂陈，却又刻骨铭心。串联每个瞬间，让更多的人看到我们心中的那段记忆。</p>
				<a href="home.php?mod=spacecp&amp;ac=memoirs">开始回忆</a>
			</div>
		</div>

		<style>
			.memoirs-recom { width: 100%; background-color: #f6f6f6; border-bottom: 1px solid #ddd; }
			.memoirs-recom .m-recom-auto { width: 1100px; margin: 0 auto; }
			.m-recom-auto .m-nav { float: left; margin-left: 10px; }
			.m-nav .m-nav-li { float: left; height: 54px; line-height: 54px; font-size: 16px; }
			.m-nav .current { margin-right: 50px; color: #ff9306; }
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
					<li class="m-nav-li current">推荐</li>
					<li class="m-nav-li"><a href="<?= Url::to(['book/index']); ?>">书库</a></li>
				</ul>

				<form id="search" class="m-search" action="<?= Url::to(['book/index']); ?>" method="post">
					<input name="_csrf" type="hidden" id="_csrf" value="<?= \Yii::$app->request->csrfToken ?>">
					<input class="m-search-input" type="text" name="m-search" placeholder="搜索你喜欢的作者或书名..." />
					<a class="m-search-a" href="javascript:document.getElementById('search').submit();"></a>
				</form>
			</div>
		</div>

		<script src="../web/js/jquery-1.8.3.min.js" type="text/javascript"></script>
		
		<script>	
			//设置搜索条滚动固定
			var d = jQuery('.memoirs-recom').offset().top;
			//设置滚动事件
			jQuery(window).scroll(function(){
				//设置鼠标滚动距顶部距离
				var s = document.documentElement.scrollTop || document.body.scrollTop;
				if(s > parseInt(d)){
					jQuery('.memoirs-recom').css({'position':'fixed','top':0,'z-index':1});
				}else{
					jQuery('.memoirs-recom').css('position','static');
				}
			})
		</script>

		<style>
			.memoirs-book { width: 100%; }
			.memoirs-book .m-book-auto { width: 1100px; margin: 0 auto; }
			.m-book-auto .book-ul { margin-left: -70px; }
			.book-ul .book-li { float: left; width: 500px; margin-left: 80px; margin-top: 50px; }
			.book-li .book-cover { float: left; width: 190px; height: 250px; position: relative; }
			.book-li .book-cover .book-img { width: 100%; height: 100%; filter: progid:DXImageTransform.Microsoft.Shadow(color='#b5b4b2', Direction=135, Strength=5); -moz-box-shadow: 0 3px 5px #b0b0b0; -webkit-box-shadow: 0 3px 5px #b0b0b0; box-shadow: 0 3px 5px #b0b0b0; }
			.book-li .book-card { background: url('../web/images/book-img-bg.png') no-repeat; width: 100%; height: 100%; opacity: 0; position: absolute; left: 0; top: 0; font-size: 14px; -webkit-transition: all 450ms ease 295ms; -moz-transition: all 450ms ease 295ms; -ms-transition: all 450ms ease 295ms; transition: all 450ms ease 295ms; } 
			.book-li .book-cover:hover .book-card { opacity: 1; -webkit-transition: all 300ms ease-out 0ms; -moz-transition: all 300ms ease-out 0ms; -ms-transition: all 300ms ease-out 0ms; transition: all 300ms ease-out 0ms; }	

			.book-li .book-card .book-card-wrap {
			display: block;
			height: 100%;
			width: 100%;
			color: #555;
			text-align: center;
			outline: 0 none;
			}

			.book-li .book-card .book-card-wrap:hover {
			text-decoration: none;
			}

			.book-li .book-card .book-card-title {
			display: block;
			height: 36px;
			opacity: 0;
			overflow: hidden;
			-webkit-transform: translateY(175px);
			-moz-transform: translateY(175px);
			-ms-transform: translateY(175px);
			transform: translateY(175px);
			-webkit-transition: all 335ms ease 230ms;
			-moz-transition: all 335ms ease 230ms;
			-ms-transition: all 335ms ease 230ms;
			transition: all 335ms ease 230ms;
			visibility: hidden;
			margin-top: 50px;
			}

			.book-li .book-cover:hover .book-card-title {
			opacity: 1;
			-webkit-transform: translateY(0px);
			-moz-transform: translateY(0px);
			-ms-transform: translateY(0px);
			transform: translateY(0px);
			-webkit-transition: all 345ms ease 250ms;
			-moz-transition: all 345ms ease 250ms;
			-ms-transition: all 345ms ease 250ms;
			transition: all 345ms ease 250ms;
			visibility: visible;
			}

			.book-li .book-card .book-card-author {
			height: 25px;
			line-height: 25px;
			margin-top: 14px;
			opacity: 0;
			-webkit-transform: translateY(139px);
			-moz-transform: translateY(139px);
			-ms-transform: translateY(139px);
			transform: translateY(139px);
			-webkit-transition: all 240ms ease 145ms;
			-moz-transition: all 240ms ease 145ms;
			-ms-transition: all 240ms ease 145ms;
			transition: all 240ms ease 145ms;
			visibility: hidden;
			}

			.book-li .book-cover:hover .book-card-author {
			opacity: 1;
			-webkit-transform: translateY(0px);
			-moz-transform: translateY(0px);
			-ms-transform: translateY(0px);
			transform: translateY(0px);
			-webkit-transition: all 440ms ease 345ms;
			-moz-transition: all 440ms ease 345ms;
			-ms-transition: all 440ms ease 345ms;
			transition: all 440ms ease 345ms;
			visibility: visible;
			}

			.book-li .book-card .book-card-btn {
			background: rgba(255, 255, 255, 0.7);
			border: 1px solid #ff9306;
			border-radius: 5px;
			color: #ff9306;
			display: block;
			height: 32px;
			line-height: 32px;
			margin: 30px auto 0;
			opacity: 0;
			-webkit-transform: translateY(66px);
			-moz-transform: translateY(66px);
			-ms-transform: translateY(66px);
			transform: translateY(66px);
			-webkit-transition: -webkit-transform 105ms ease 30ms,opacity 105ms ease 30ms;
			-moz-transition: -moz-transform 105ms ease 30ms,opacity 105ms ease 30ms;
			-ms-transition: -ms-transform 105ms ease 30ms,opacity 105ms ease 30ms;
			transition: transform 105ms ease 30ms, opacity 105ms ease 30ms;
			width: 80px;
			visibility: hidden;
			}

			.book-li .book-cover:hover .book-card-btn {
			opacity: 1;
			-webkit-transform: translateY(0px);
			-moz-transform: translateY(0px);
			-ms-transform: translateY(0px);
			transform: translateY(0px);
			-webkit-transition: -webkit-transform 605ms ease 525ms, opacity 605ms ease 525ms;
			-moz-transition: -moz-transform 605ms ease 525ms, opacity 605ms ease 525ms;
			-ms-transition: -ms-transform 605ms ease 525ms, opacity 605ms ease 525ms;
			transition: transform 605ms ease 525ms, opacity 605ms ease 525ms;
			visibility: visible;
			}

			.book-li .book-card .book-card-btn:hover {
				box-shadow: 0 1px 2px #b8b8b8;
			}

			.book-li .book-info { float: left; width: 280px; margin-left: 30px; }
			.book-info .book-title { font-size: 18px; font-weight: normal; height: 40px; line-height: 40px; }
			.book-info .book-title a { color: #000; }
			.book-info .book-title a:hover { color: #ff9306; text-decoration: none; }
			.book-info p { color: #666; font-size: 14px; }
			.book-info .book-author { margin-top: 26px; }
			.book-info .book-author a { color: #000; }
			.book-info .book-job { margin-top: 14px; }
			.book-info .book-des { margin-top: 20px; }
			.m-book-auto .book-more { display: block; font-size: 16px; color: #666; text-align: right; padding-right: 10px; margin-top: 30px; }
		</style>

		<div class="memoirs-book">
			<div class="m-book-auto">
				<ul class="book-ul cl">
					<?php foreach($data as $info){ ?>	
						<li class="book-li">
							<div class="book-cover">
								<img class="book-img" src="../web/images/<?=$info['cover']; ?>" />
								<div class="book-card">
									<a class="book-card-wrap" href="<?= Url::to(['read/index','id'=>$info['bookid']]); ?>" target="_blank">
										<span class="book-card-title"><?=$info['bookname']; ?></span>
										<p class="book-card-author"><?=$info['viewnum']; ?>人查看</p>
										<span class="book-card-btn">阅读</span>
									</a>
								</div>
							</div>
							<!-- 隐藏书籍ID   -->
							<input type="hidden" name="bookid" value="<?= $info['bookid'] ?>">

							<div class="book-info">
								<h2 class="book-title"><a href="<?= Url::to(['read/index','id'=>$info['bookid']]); ?>" target="_blank"><?=$info['bookname']; ?></a></h2>
								<p class="book-author">作者：<a href="home.php?mod=space&amp;uid=277" target="_blank"><?=$info['username']; ?></a></p>
								<p class="book-job"><?=$info['tag']; ?></p>
								<p class="book-des"><?= mb_substr($info['introduction'], 0, 91, 'utf-8'); ?>&nbsp;...</p>
							</div>
						</li>
					<?php 
						}
					?>
				</ul>
				<!-- 单击阅读后，对应的阅读量+1 -->
				<script>
					jQuery(function(){
						//将阅读按钮和书籍标题绑定同一单击事件
						jQuery('.book-card-btn, .book-title').click(function(){
							var bookid = jQuery(this).parents('li').find('input').val();
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

				<a class="book-more" href="<?= Url::to(['book/index']); ?>">查看更多></a>
			</div>
		</div>
	</div>	
</div>