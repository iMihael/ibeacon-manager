<?php

namespace app\modules\v1\controllers;

use app\models\Token;
use app\models\User;
use app\modules\v1\components\QueryParamAuth;
use Yii;
use yii\filters\ContentNegotiator;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

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
        $u = new User();
        $u->setScenario('login');

        if($u->load(Yii::$app->request->post(), '') && $u->validate()) {
            $t = Token::createToken($u->id);
            $u->token = $t->value;
            return $u;

        } else {
            throw new UnauthorizedHttpException();
        }

    }

    public function checkAccess($action, $model = null, $params = []) {

        throw new ForbiddenHttpException();
    }
}
