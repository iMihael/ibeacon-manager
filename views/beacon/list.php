<?php

use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'iBeacons';
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <a href="<?= Url::toRoute(['/beacon/add']) ?>" class="btn btn-primary">Add iBeacon</a>
    <button disabled class="btn btn-default">Import from kontakt.io</button>
    <button disabled class="btn btn-default">Import from Estimote</button>
</p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'identifier',
            'uuid',
            'major',
            'minor'
        ],
    ]) ?>
