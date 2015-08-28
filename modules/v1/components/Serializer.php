<?php

namespace app\modules\v1\components;

use yii\base\Arrayable;
use yii\helpers\ArrayHelper;

class Serializer extends \yii\rest\Serializer {
    public $excludeParam = 'exclude';


    protected function getRequestedFields()
    {
        $fields = $this->request->get($this->fieldsParam);
        $expand = $this->request->get($this->expandParam);
        $exclude = $this->request->get($this->excludeParam);

        return [
            preg_split('/\s*,\s*/', $fields, -1, PREG_SPLIT_NO_EMPTY),
            preg_split('/\s*,\s*/', $expand, -1, PREG_SPLIT_NO_EMPTY),
            preg_split('/\s*,\s*/', $exclude, -1, PREG_SPLIT_NO_EMPTY),
        ];
    }

    protected function serializeModel($model)
    {
        if ($this->request->getIsHead()) {
            return null;
        } else {
            list ($fields, $expand, $exclude) = $this->getRequestedFields();
            $array = $model->toArray($fields, $expand);
            foreach($exclude as $e) {
                if(array_key_exists($e, $array)) {
                    unset($array[$e]);
                }
            }

            return $array;
        }
    }

    protected function serializeModels(array $models)
    {
        list ($fields, $expand, $exclude) = $this->getRequestedFields();
        foreach ($models as $i => $model) {
            if ($model instanceof Arrayable) {
                $models[$i] = $model->toArray($fields, $expand);
                foreach($exclude as $e) {
                    if(array_key_exists($e, $models[$i])) {
                        unset($models[$i][$e]);
                    }
                }
            } elseif (is_array($model)) {
                $models[$i] = ArrayHelper::toArray($model);
            }
        }

        return $models;
    }
}