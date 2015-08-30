<?php

namespace app\modules\v1\controllers;

use app\models\Beacon;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;

class BeaconController extends BaseController {
    public $modelClass = 'app\models\Beacon';

    public function actionSearch() {
        return new ActiveDataProvider([
            'query' => Beacon::find()->haveAccess()
        ]);
    }

    public function checkAccess($action, $model = null, $params = []) {

        throw new ForbiddenHttpException();
    }
}