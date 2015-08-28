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
                        'actions' => ['list', 'add', 'delete', 'edit', 'import-kontakt', 'import-estimote'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionImportEstimote() {
        $model = Yii::$app->user->identity;
        $model->setScenario('estimote-import');

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();

            $counter = Beacon::importEstimote($model->estimoteAppId, $model->estimoteAppToken);

            return $this->render('import-estimote', [
                'model' => $model,
                'counter' => $counter,
            ]);
        }


        return $this->render('import-estimote', [
            'model' => $model,
        ]);
    }

    public function actionImportKontakt() {

        $model = Yii::$app->user->identity;
        $model->setScenario('kontakt-import');

        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();

            $counter = Beacon::importKontakt($model->kontaktKey);

            return $this->render('import-kontakt', [
                'model' => $model,
                'counter' => $counter,
            ]);
        }

        return $this->render('import-kontakt', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        if($beacon = Beacon::findOne(['id' => $id, 'userId' => Yii::$app->user->id])) {
            $beacon->delete();
            return $this->redirect(['/beacon/list']);
        }

        return $this->goBack();
    }

    public function actionEdit($id) {
        if($beacon = Beacon::findOne(['id' => $id, 'userId' => Yii::$app->user->id])) {
            $beacon->setScenario('edit');

            if($beacon->load(Yii::$app->request->post()) && $beacon->validate()) {
                $beacon->save();
                return $this->goBack();
            }

            return $this->render('edit', ['model' => $beacon]);

        } else {
            return $this->goBack();
        }
    }

    public function actionList() {

        $p = Yii::$app->request->post();

        return $this->render('list', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Beacon::find()->andWhere(['userId' => Yii::$app->user->id])->orderBy('updatedAt DESC')
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