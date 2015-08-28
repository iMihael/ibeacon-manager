<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Import from Estimote.com';
$this->params['breadcrumbs'][] = ['url' => ['/beacon/list'], 'label' => 'iBeacons'];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="">
    <div class="col-lg-6">

        <?php $form = ActiveForm::begin([
            'id' => 'import-form',
        ]); ?>




        <? if( isset($counter) && $counter > 0) { ?>
            <div class="alert alert-success">
                Successfully imported <?= $counter ?> beacons
            </div>

        <? } else if(isset($counter) && $counter == 0) { ?>

            <div class="alert alert-warning">
                No beacons were imported
            </div>

        <? } ?>

        <?= $form->field($model, 'estimoteAppId') ?>
        <?= $form->field($model, 'estimoteAppToken') ?>

        <div class="form-group">

            <?= Html::submitButton('Import', ['class' => 'btn btn-primary', 'name' => 'import-button']) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="col-lg-6">
        <p>
            We need to authenticate your requests with your unique API credentials. You’ll find them in the Account Settings tab in the Estimote Cloud web panel.
            All requests to Estimote API have to be authenticated using the standard HTTP Basic Authentication mechanism.
        </p>
        <p>
            To obtain App Id and App Token, you must create an app in cloud panel <a href="https://cloud.estimote.com/#/apps">https://cloud.estimote.com/#/apps</a> (or use existing one) and copy it to import form.
        </p>
    </div>
</div>