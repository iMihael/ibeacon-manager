<?php

namespace app\modules\v1\controllers;

use app\modules\v1\components\QueryParamAuth;
use Yii;
use yii\filters\ContentNegotiator;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class UserController extends BaseController {
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => QueryParamAuth::className(),
                'tokenParam' => 'token',
                'except' => ['login']
            ],
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ]
        ];
    }

    public function actionLogin() {
        //TODO: implement REST login
    }

    public function checkAccess($action, $model = null, $params = []) {

        throw new ForbiddenHttpException();
    }
}
