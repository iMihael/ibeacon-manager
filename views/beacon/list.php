<?php

use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'iBeacons';
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <a href="<?= Url::toRoute(['/beacon/add']) ?>" class="btn btn-primary">Add iBeacon</a>
    <a href="<?= Url::toRoute(['/beacon/import-kontakt']) ?>" class="btn btn-default">Import from Kontakt.io</a>
    <a href="<?= Url::toRoute(['/beacon/import-estimote']) ?>" class="btn btn-default">Import from Estimote.com</a>
</p>

    <form method="POST">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

    <?= GridView::widget([
        'id' => 'beacons-grid',
        'dataProvider' => $dataProvider,
        'layout' => '{summary}{items}<div class="pull-left">
    <img src="img/arrow_ltr.png">
    <button type="submit" class="btn btn-default selected-delete" >Delete Selected</button>
</div>{pager}',
        'columns' => [
            [
                'header' => Html::input('checkbox'),
                'format' => 'raw',
                'value' => function($model) {
                    return Html::input('checkbox', 'beacon[' . $model->id . ']', $model->id);
                },
            ],
            'id',
            'identifier',
            'uuid',
            'major',
            'minor',
            [
                'header' => 'Actions',
                'value' => function($model){
                    return '<div style="width:100px;" class="btn-group">
                                        <a class="btn btn-default" href="'.Url::toRoute(['/beacon/edit', 'id' => $model->id]).'"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a class="btn btn-default" onclick="return confirm(\'Are you sure you want to delete this iBeacon ?\')" href="'.Url::toRoute(['/beacon/delete', 'id' => $model->id]).'"><span class="glyphicon glyphicon-trash"></span></a>
                                    </div>';
                },
                'format' => 'raw',
                'headerOptions' => [
                    'style' => 'width:100px;'
                ],
            ],
        ],
    ]) ?>

    </form>


