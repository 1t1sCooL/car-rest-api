<?php

namespace app\controllers;

use app\models\common\entities\CarOption;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use Yii;
use app\models\common\entities\Car;

class CarController extends ActiveController
{
    public $modelClass = 'app\models\common\entities\Car';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => \yii\web\Response::FORMAT_JSON,
        ];
        return $behaviors;
    }

    public function actionCreated()
{
    $data = \Yii::$app->request->bodyParams;

    $car = new Car();
    $car->load($data, '');

    if ($car->save()) {
        $opt = new CarOption();
        $opt->load($data['options'], '');
        $opt->car_id = $car->id;

        if (!$opt->save()) {
            \Yii::error("Ошибка сохранения CarOption: " . json_encode($opt->errors), __METHOD__);
        }
    }

        \Yii::$app->response->statusCode = 201;
        return $this->actionView($car->id);

}

    public function actionView($id)
{
    $car = Car::find()->where(['id' => $id])->one();
    if (!$car) {
        throw new NotFoundHttpException("Not found");
    }

    return $car->toArray();
}


    public function actionList($page = 1)
{
    $cars = Car::find()
        ->with('options')
        ->orderBy(['created_at' => SORT_DESC])
        ->offset(($page - 1) * 10)
        ->limit(10)
        ->all();

    return array_map(function ($car) {
        $options = [];

        foreach ($car->options as $opt) {
            $options[] = [
                'brand' => $opt->brand,
                'model' => $opt->model,
                'year' => $opt->year,
                'body' => $opt->body,
                'mileage' => $opt->mileage,
            ];
        }

        return array_merge(
            $car->toArray(),
            ['options' => $options]
        );
    }, $cars);
}

}
