<?php use yii\helpers\Url; ?>
<link rel="stylesheet" href="../web/css/author.css">
<link rel="stylesheet" href="../web/css/mu.css">
<script type="text/javascript" src="../web/js/common_read.js"></script>

<!-- 文章内容头部 -->
<div id="panel">
	<span class="rd-title"><?= $data['bookname']; ?></span>
	<span class="rd-time fr">发布时间：<?= date('Y-m-d H:i:s',$data['lasttime']); ?></span>
</div>

<input type="hidden" name="previd" value="" />
<?php if(isset($chapter)){foreach($chapter as $v){$cid[] = $v['chapterid'];} $cmin=min($cid); $cmax=max($cid);} ?>	

<!-- 文章内容主体 -->
<div id="cnbox">
	<div class="rd-cn" data-now-chapter="<?= $chapterinfo['chapterid']; ?>" data-next-chapter="<?php if($chapterinfo['chapterid']<$cmax){echo $chapterinfo['chapterid']+1;} ?>" data-prev-chapter="<?php if($chapterinfo['chapterid']>$cmin){echo $chapterinfo['chapterid']-1;} ?>">
		<div class="cn-wrap">
			<div class="art-content">
				<span class="text"></span>
				<h2><?= $chapterinfo['subject']; ?></h2>
				<div>
					<p><?= $chapterinfo['message']; ?></p>
				</div>
			</div>
		</div>
	</div>	
</div>

<!-- 文章内容尾部 -->
<div id="pfoot"></div>

<div class="popo">正在加载上一章....</div>
<input type="hidden" name="nextid" value="<?php if($chapterinfo['chapterid']<$cmax){echo $chapterinfo['chapterid']+1;} ?>" />
<input type="hidden" name="nowid" value="<?= $chapterinfo['chapterid']; ?>" />
<input type="hidden" name="subject" value="<?= $chapterinfo['subject']; ?>" />

<script type="text/javascript">
	jQuery.noConflict();
	jQuery('.popo').css({'left':(jQuery(window).width()-jQuery('.popo').width())/2,'bottom':'200px'});
	jQuery(window).scroll(function(){
		if(jQuery(window).scrollTop() == 0){
			var oPrev = jQuery('.rd-cn').eq(0).attr('data-prev-chapter');
			url = 'index.php?r=read/content';//url跳转
			var cmin = <?= $cmin; ?>;//当前书籍最小的章节ID
			if(oPrev != ''){
				jQuery.ajax({
					url:url,
					type:'get',
					data:{chapterid:oPrev},
					dataType:'json',
					success:function(data){
						if(data){
							var prev = parseInt(data.chapterid)-1 < cmin ? '' : parseInt(data.chapterid)-1;//限定上一页
							var str = '<div class="rd-cn" data-now-chapter="'+data.chapterid+'" data-next-chapter="'+(parseInt(data.chapterid)+1)+'" data-prev-chapter="'+prev+'"><div class="cn-wrap"><div class="art-content"><span class="text"></span><h2>'+data.subject+'</h2><div><p>'+data.message+'</p></div></div></div></div>';
							jQuery('#cnbox').prepend(str);	
							jQuery('.popo').html('正在加载上一章....');	
						}
					}
				})
			}else{
				jQuery('.popo').html('已经到第一章了....');	
			}

			jQuery('.popo').css({'left':(jQuery(window).width()-jQuery('.popo').width())/2,'top':'200px'});
			jQuery('.popo').fadeIn();
			setTimeout(function(){
				jQuery('.popo').fadeOut();
			},2000);
		}

		if (jQuery(document).scrollTop() == jQuery(document).height() - jQuery(window).height()) {
			var oNext = jQuery('.rd-cn').eq(jQuery('.rd-cn').length-1).attr('data-next-chapter');
			// alert(oNext);exit;
			url = 'index.php?r=read/content';//url跳转	
			var cmax = <?= $cmax; ?>;//当前书籍最大的章节ID
			if(oNext != ''){
				jQuery.ajax({
					url:url,
					type:'get',
					data:{chapterid:oNext},
					dataType:'json',
					success:function(data){
						if(data){
							var next = parseInt(data.chapterid)+1 > cmax ? '' : parseInt(data.chapterid)+1;//限定下一页
							var str = '<div class="rd-cn" data-now-chapter="'+data.chapterid+'" data-next-chapter="'+next+'" data-prev-chapter="'+(parseInt(data.chapterid)-1)+'"><div class="cn-wrap"><div class="art-content"><span class="text"></span><h2>'+data.subject+'</h2><div><p>'+data.message+'</p></div></div></div></div>';
							jQuery('#cnbox').append(str);		
							jQuery('.popo').html('正在加载下一章....');	
							jQuery('.art-content').css('font-size',jQuery('.curent').attr('data')+'px');
						}
					}
				})		
			}else{
				jQuery('.popo').html('已到最后一章了....');	
			}

			jQuery('.popo').css({'left':(jQuery(window).width()-jQuery('.popo').width())/2,'bottom':'200px'});
			jQuery('.popo').fadeIn();

			setTimeout(function(){
				jQuery('.popo').fadeOut();
			},2000);
		}
	})
</script>	

<!-- 侧边工具 -->
<div id="tool">
	<ul>
		<li>
			<span id="fontsize" class="tool-btn">字号</span>
			<div class="font">
				<ul>
					<li  data='20'>大</li>
					<li class="curent" data='16'>中</li>
					<li data='14'>小</li>
				</ul>
			</div>
		</li>

		<li>
			<a class="tri" href="javascript:;">目录</a>
			<div class="catalog-box">
				<div class="hd">
					<h2>目录</h2>
				</div>
				<div class="bd">
					<!-- 判断卷是否为空，不为空则遍历所有卷名 -->
		            <?php if(!empty($volume)){ foreach($volume as $v){ ?>
		                <dl>
		                    <dt><span><?=$v['volumename'];?></span></dt>
		                    <!-- 判断卷对应的章节是否为空，不为空则遍历所有对应的章节 -->
		                    <?php if(!empty($v['chapter'])){ foreach($v['chapter'] as $chapter){ ?>
		                        <dd class="c-teshu"><a href="<?= Url::to(['read/content', 'chapterid'=>$chapter['chapterid']]); ?>"><?= $chapter['subject']; ?></a></dd>
		                    <?php } } ?>
		                </dl>
		            <?php } }else{ ?>
		                <dl>
		                    <!-- 卷不存在时，遍历所有的章节 -->
		                    <?php foreach($chapter as $row){ ?>					
		                        <dt><a href="<?= Url::to(['read/content', 'chapterid'=>$row['chapterid']]); ?>"><?= $row['subject']; ?></a></dt>
		                    <?php } ?>
		                </dl>
		            <?php } ?>
					<dl class="zuihou"></dl>
				</div>
			</div>
		</li>

		<li>
			<span class="page-prev">上一页</span>
		</li>

		<li>
			<span class="page-next">下一页</span>
		</li>
	</ul>
</div>

<script>
	jQuery('#add-mark').click(function(){
		//alert(1);
		var oNow = jQuery('.rd-cn').eq(jQuery('.rd-cn').length-1).attr('data-now-chapter');
		//alert(oNow);
		var str = '';
		jQuery.post('memoirs.php?mod=content&chapterid='+oNow,{'nowid':oNow,'method':'add'},function(data){
			if(data.status==1){
				str +='<li><div class="mark-tit">';
				str +='<h4><a href="memoirs.php?mod=content&amp;chapterid='+oNow+'">'+jQuery('input[name=subject]').val()+'</a></h4>';
				str +='<span>'+data.dateline+'</span></div><i class="flag"></i><a class="delete">删除</a></li>';
				jQuery('.list-mark').prepend(str)		
			}

			if(data.status == 2){
				jQuery('.popo').css({'left':(jQuery(window).width()-jQuery('.popo').width())/2,'top':'200px'});
				jQuery('.popo').html('本章已经添加过书签');	
				jQuery('.popo').fadeIn();
				setTimeout(function(){jQuery('.popo').fadeOut();},1500);
			}
		},'json');
		return false;
	});

	jQuery('.delete').click(function(){
		var This = jQuery(this);
		jQuery.post('memoirs.php?mod=content&chapterid='+oNow,{markid:jQuery(this).attr('data-vid'),method:'del'},function(data){
			if(data.status){
				This.parent('li').remove();
			}
		},'json');
		return false;
	});			


	jQuery('.list-mark').find('li').each(function(i){
		jQuery(this).hover(function(){
			jQuery(this).find('.delete').show();
		},function(){
			jQuery(this).find('.delete').hide();
		});
	})

	jQuery('.font').find('li').each(function(){
		jQuery(this).click(function(){
			jQuery(this).addClass('curent').siblings('li').removeClass('curent');
			jQuery('.art-content').css('font-size',jQuery(this).attr('data')+'px');
		})
	});

	jQuery('#fontsize').click(function(){
		jQuery('.font').fadeIn();
		return false;
	})

	jQuery(window).click(function(){
		jQuery('.font').fadeOut();
	});
</script>