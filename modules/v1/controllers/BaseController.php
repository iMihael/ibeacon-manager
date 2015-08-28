<?php

namespace app\modules\v1\controllers;

use app\modules\v1\components\QueryParamAuth;
use Yii;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

class BaseController extends ActiveController {
    public $createScenario = 'rest-create';
    public $updateScenario = 'rest-update';
    public $deleteScenario = 'rest-delete';

    public $serializer = 'app\modules\v1\components\Serializer';

    const ACTION_DELETE = 'delete';
    const ACTION_INDEX = 'index';
    const ACTION_VIEW = 'view';
    const ACTION_UPDATE = 'update';
    const ACTION_CREATE = 'create';

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => QueryParamAuth::className(),
                'tokenParam' => 'token',
            ],
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ]
        ];
    }
}