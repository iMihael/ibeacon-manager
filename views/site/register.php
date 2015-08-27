<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-register">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>

        <div class="panel-body">
            <p class="col-lg-offset-1">Please fill out the following fields to register:</p>

            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]); ?>

            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'firstName') ?>
            <?= $form->field($model, 'lastName') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>

