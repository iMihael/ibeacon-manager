<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Edit iBeacon';
$this->params['breadcrumbs'][] = ['url' => ['/beacon/list'], 'label' => 'iBeacons'];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-login">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>

        <div class="panel-body">
            <p class="col-lg-offset-2">Please fill out the following fields to edit a beacon:</p>


            <?php $form = ActiveForm::begin([
                'id' => 'beacon-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
            ]); ?>

            <?= $form->field($model, 'identifier') ?>
            <?= $form->field($model, 'uuid') ?>
            <?= $form->field($model, 'major') ?>
            <?= $form->field($model, 'minor') ?>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-11">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>


            <?php ActiveForm::end(); ?>


        </div>

    </div>

</div>
