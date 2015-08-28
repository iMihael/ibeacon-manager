<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Import from Kontakt.io';
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

        <?= $form->field($model, 'kontaktKey') ?>

        <div class="form-group">

            <?= Html::submitButton('Import', ['class' => 'btn btn-primary', 'name' => 'import-button']) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="col-lg-6">
        <p>All requests to the Kontakt.io API require an <code>Api-Key</code> header containing your <strong>API key</strong>.  Your API key is unique and gives you secure access to your Devices and other resources.</p>

        <p><strong>To get your SUPERUSER manager API key from the WebPanel:</strong></p>


        <ul>
            <li>Sign into your Kontakt.io <a href="https://panel.kontakt.io" title="Kontakt.io Web Panel">Proximity Web Panel account</a>.<br>
                If you haven't already done this, then check out our article
                <a href="https://kontaktio.zendesk.com/hc/en-gb/articles/201499312">How to sign in to your Kontakt.io Proximity Web Panel for the first time</a>
            </li>
            <li>
                On the footer of the Web Panel page, you'll see a link to <strong>Get API key</strong> at the bottom left. Click the link to display your key.
            </li>
        </ul>
    </div>
</div>