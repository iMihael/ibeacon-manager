<?php

namespace app\modules\v1\components;
use yii\filters\auth\AuthMethod;
use Yii;
use yii\web\UnauthorizedHttpException;

class QueryParamAuth extends AuthMethod {
    public $tokenParam = 'token';

    public function authenticate($user, $request, $response) {
        $accessToken = $request->get($this->tokenParam, false);

        if(!$accessToken) {
            $accessToken = $request->post($this->tokenParam, false);
        }

        if(!$accessToken && Yii::$app->request->cookies->has($this->tokenParam)) {
            $accessToken = \Yii::$app->request->cookies->getValue($this->tokenParam);
        }

        if(!$accessToken && array_key_exists($this->tokenParam, $_COOKIE)) {
            $accessToken = str_replace('"', '', $_COOKIE[$this->tokenParam]);
        }

        if (is_string($accessToken)) {
            $identity = $user->loginByAccessToken($accessToken, get_class($this));


            if ($identity !== null) {
                $identity->token = $accessToken;
                Yii::$app->user->identity = $identity;
                return $identity;
            }
        }

        if ($accessToken !== null) {
            throw new UnauthorizedHttpException();
        }

        return null;
    }
}