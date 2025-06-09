<?php

namespace app\models\common\entities;

use yii\db\ActiveRecord;

class CarOption extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'car_option';
    }

    public function rules()
    {
        return [
            [['car_id',  'year', 'mileage', 'brand', 'model', 'body'], 'required'],
            [['car_id', 'year', 'mileage'], 'integer'],
            [['brand', 'model', 'body'], 'string'],
        ];
    }

    public function getCar()
    {
        return $this->hasOne(Car::class, ['id' => 'car_id']);
    }
    public function fields()
{
    return ['year', 'mileage', 'brand', 'model', 'body'];
}
}
