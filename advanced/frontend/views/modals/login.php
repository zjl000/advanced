<?php
use common\models\LoginForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
$modelLog = new LoginForm;
Modal::begin([
    'id' => 'loginform',
    'header' => '用户登录',
    'size' => Modal::SIZE_SMALL,
    'closeButton' => [
        'label' => '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',
    ],
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
        'show' =>false
    ]
]);
?>
    <div class="login-modal">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <?php $form = ActiveForm::begin([
                    'id'=> 'login-form',
                    'action' => Yii::$app->controller->action->id == 'reset-password'?'/site/login':'/site/login?location=/'.Yii::$app->controller->getRoute(),
                ]); ?>
                <div><?php //echo $form->errorSummary($modelLog); ?></div>
                <?php echo $form->field(
                    $modelLog,
                    'username',
                    ['template' => '<div class="input-group"><div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>{input}</div>{error}']
                )->textInput(['placeholder' => '手机号/邮箱']) ?>
                <?php echo $form->field(
                    $modelLog,
                    'password',
                    ['template' => '<div class="input-group"><div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>{input}</div>{error}']
                )->passwordInput(['placeholder' => '密码']) ?>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <?= $form->field($modelLog, 'rememberMe')->checkbox() ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div style="margin-top:10px;margin-top: 10px;text-align: right">
                        <?= Html::a('忘记密码？', ['site/request-password-reset'],['style'=>'color:#92b270;']) ?>
                    </div>
                </div>

                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                    <?php echo Html::submitButton('登录', ['class' => 'btn btn-primary btn-block']); ?>
                </div>
                <div style="text-align: right;" class="col-lg-12 col-md-12 col-sm-12">
                    您还没有账号?<?= Html::a('马上注册!', ['site/signup'],['style'=>'color:#92b270;']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
Modal::end();
?>