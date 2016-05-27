<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
	<?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/res/site/logo_small.png', ['alt' => Yii::$app->id]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-fixed-top',
        ],
    ]);
    $menuItemsLeft = [
        ['label' => '家族圈', 'url' => ['/site/index']],
        ['label' => '回忆录', 'url' => ['/site/memoirs']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
        $menuItems[] = [
			'label' => '登录', 
			'url' => ['#'], 
			'linkOptions' => [
				'onclick' => 'javascript:;',
				'data-toggle' => 'modal',
				'data-target' => '#loginform'
			]
		];
    } else {
        $menuItems[] = [
            'label' => '退出 (' . Yii::$app->user->identity->username . ')',
			'url' => ['/site/logout'],
			'linkOptions' => ['data-method' => 'post']
        ];    
    }
    echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $menuItemsLeft,
	]);
	echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
	<?php if(isset($this->blocks['block1'])):?>
		<div class="fullscreen-bg"></div>
	<?php else:?>
		<div class="space-bg"></div>
	<?php endif;?>	
	<div class="container">
        <div class="space-hd cl">
			<div class="hd-avatar">
				<div class="img-up">
					<?= Html::img('@web'.$this->context->layout_data['avatar']) ?>
				</div>
				<?= Html::img('@web/res/site/avatar_bg.png', ['class' => 'img-down']) ?>
			</div>
			<div class="hd-info">
				<span><?=$this->context->layout_data['account']?></span>
				<p><?=$this->context->layout_data['motto']?></p>
			</div>
		</div>
		<div class="space-by cl">
			<div class="by-left">
				<ul>					
					<?php foreach($this->context->navarr as $key => $value):?>
						<?php if($key == 'set' && (Yii::$app->user->isGuest || Yii::$app->user->identity->id != $_GET['uid'])){
							break;
						}?>								
						<li <?php if($key == $this->context->action->id){echo 'class="a"';} ?>>
							<a href="<?=$key,'?uid='.$_GET['uid']?>"><i class="<?=$key?>-icon"></i><?=$value?></a>
						</li>
					<?php endforeach;?>															
				</ul>
			</div>
			<div class="by-right">
				<?= Alert::widget() ?>
				<?= $content ?>
			</div>
		</div>		
    </div>
</div>

<?php echo $this->renderFile('@frontend/views/modals/login.php');?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
