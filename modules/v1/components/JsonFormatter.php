<?php

namespace app\modules\v1\components;

use yii\helpers\Json;
use yii\web\JsonResponseFormatter;

class JsonFormatter extends JsonResponseFormatter {

    protected function formatJson($response)
    {
        $response->getHeaders()->set('Content-Type', 'application/json; charset=UTF-8');
        if ($response->data !== null) {
            if(YII_ENV == 'dev') {
                $response->content = Json::encode($response->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            } else {
                $response->content = Json::encode($response->data);
            }
        }
    }

}