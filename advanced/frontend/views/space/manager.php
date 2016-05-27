<?php 
	use yii\helpers\Html;
	use yii\helpers\Url;
?>

<div id="wp" class="wp cl">
	<style>
		#wp { padding-top: 20px; position: relative; }
	</style>
	<div class="m_tit">
		<span>我的往事</span>
		<?= Html::a('退出管理', Url::to(['space/memoirs', 'uid'=>$data['uid']]), ['class'=>'btn btn-success']); ?>
	</div>
	<div class="m_info">
		<img src="images/<?= $data['cover'] ?>" alt="<?= $data['bookname'] ?>">
		<div class="text">
			<h2><a href="#"><?= $data['bookname'] ?></a></h2>
			<p class="count"><?= $data['viewnum'] ?>人在阅读</p>
			<p class="tag">标签：<?= $data['tag'] ?></p>
			<p class="desc"></p>				
		</div>
		<div class="do">
			<div class="z">
				<?= Html::a('修改信息', Url::to(['space/update', 'uid'=>$data['uid'], 'bookid'=>$data['bookid']]), ['class'=>'cbtn']); ?>
				<!-- <a href="http://heye.online/home.php?mod=spacecp&amp;ac=memoirs&amp;bookid=64" class="cbtn">修改信息</a> -->
				<a href="http://heye.online/home.php?mod=spacecp&amp;ac=chapter&amp;op=nostatus&amp;bookid=64" id="64" onclick="showWindow(this.id, this.href, 'get', 0);" class="cbtn">取消审核</a>
				<span>您的作品正在审核中</span>
			</div>
			<div class="y">
				<a href="<?= Url::to(['space/delete', 'bookid'=>$data['bookid']]) ?>" id="64" onclick="showWindow(this.id, this.href, 'get', 0);">删除本作品</a>
			</div>
		</div>
		<div class="cl"></div>
	</div>
</div>