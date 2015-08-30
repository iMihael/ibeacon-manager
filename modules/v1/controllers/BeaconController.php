<?php

namespace app\modules\v1\controllers;

class BeaconController extends BaseController {
    public $modelClass = 'app\models\Beacon';

    public function checkAccess($action, $model = null, $params = []) {

        //throw new ForbiddenHttpException();
    }
}