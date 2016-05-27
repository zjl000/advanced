<?php
	/* @var $this yii\web\View */
	use yii\helpers\Html;
	use yii\helpers\Url;
	$this->title = Yii::$app->id .'-'. Yii::t('common', 'Space Memoirs');
	$this->registerCssFile(Yii::$app->request->baseUrl.'/css/space.css', ['depends' => ['frontend\assets\AppAsset']]);
?>

<div class="nav">
	<p>创建往事</p>
	<div class="link">
		<?= Html::a('返回', Url::to(['space/memoirs', 'uid'=>$_GET['uid']]), ['class'=>'btn btn-success']); ?>
	</div>
</div>

<div class="content">
	<?= $this->render('_form', ['model'=>$model]); ?>
</div>