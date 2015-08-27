<?php

namespace app\controllers;

use app\models\Beacon;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class BeaconController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['list', 'add'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionList() {

        return $this->render('list', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Beacon::find()->where(['userId' => Yii::$app->user->id])
            ]),
        ]);

    }

    public function actionAdd() {

        $model = new Beacon();
        $model->setScenario('create');
        $model->userId = Yii::$app->user->id;

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            $this->redirect(['beacon/list']);
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

}