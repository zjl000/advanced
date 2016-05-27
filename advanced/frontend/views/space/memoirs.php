<?php
	/* @var $this yii\web\View */
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	$this->title = Yii::$app->id .'-'. Yii::t('common', 'Space Memoirs');
	$this->registerCssFile(Yii::$app->request->baseUrl.'/css/space.css', ['depends' => ['frontend\assets\AppAsset']]);
?>
<!-- 内容区域 -->
<!-- 导航 -->
<div class="nav">
	<p>我的往事</p>
	<div class="link">
		<?= Html::a('创建往事', Url::to(['space/create', 'uid'=>$_GET['uid']]), ['class'=>'btn btn-success']); ?>
	</div>
</div>
<!-- 遍历回忆录书籍 -->
<div class="content">
	<?php foreach($memoirs as $v){ ?>
		<div class="c_main">
			<div class="c_img">
				<a class="read1" href="<?= Url::to(['read/index', 'id'=>$v['bookid']]); ?>"><img src="../web/images/<?= $v['cover']; ?>" alt="书籍封面" width="150px" height="200px"></a>
			</div>
			<div class="c_con">
				<div class="con1">
					<a class="read2" href="<?= Url::to(['read/index', 'id'=>$v['bookid']]); ?>"><?= $v['bookname']; ?></a>
					<p>全站可见</p>
				</div>
				<div class="con2">
					<p><em><?= $v['viewnum']; ?></em>人在阅读</p>
					<p>标签：<?= $v['tag']; ?></p>
					<!-- <p>文体类型：<?php if($v['publication'] == 0){echo '回忆录';}else{echo '随笔';} ?></p> -->
				</div>
				<div class="con3">
					<!-- <a href="">管理</a>
					<a href="">阅读</a> -->
					<?= Html::a('管理', Url::to(['space/manager', 'bookid'=>$v['bookid']]), ['class'=>'btn btn-success']); ?>	
					<?= Html::a('阅读', Url::to(['read/index', 'id'=>$v['bookid']]), ['class'=>'btn btn-success read3']); ?>
				</div>
			</div>
			<!-- 隐藏书籍ID   -->
			<input type="hidden" name="bookid" value="<?= $v['bookid'] ?>">
		</div>
	<?php } ?>
	<?= LinkPager::widget(['pagination'=>$page]) ?>
</div>

<!-- 单击阅读后，阅读量+1 -->
<?php $this->beginBlock('num') ?>
	$(function(){
		$('.read1, .read2, .read3').click(function(){
			var bookid = $(this).parents('.c_main').find('input').val();
			var url = 'index.php?r=recommand/update';
			jQuery.ajax({
				url:url,
				type:'get',
				data:{bookid:bookid},
				success:function(data){
	
				}
			})
		})
	})
<?php $this->endBlock(); ?>
<?php $this->registerJs($this->blocks['num'], \yii\web\View::POS_END); ?>
