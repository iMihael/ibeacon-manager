<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class ProfileController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {

        $model = Yii::$app->user->identity;
        $model->setScenario('profile');

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();

            return $this->render('index', [
                'model' => $model,
                'saved' => true,
            ]);
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }

}