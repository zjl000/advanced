<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->id .'-'. Yii::t('common', 'Space Home');
$this->registerCssFile(Yii::$app->request->baseUrl.'/css/space.css', ['depends' => ['frontend\assets\AppAsset']]);
?>
<?php $this->beginBlock('block1');?>
	<div class="fullscreen-bg"></div>
<?php $this->endBlock();?>