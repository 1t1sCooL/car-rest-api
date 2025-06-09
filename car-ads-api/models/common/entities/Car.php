<?php

namespace app\models\common\entities;

use yii\db\ActiveRecord;

class Car extends ActiveRecord
{
    public static function tableName()
    {
        return 'car';
    }

    public function rules()
{
    return [
        [['title', 'year', 'price'], 'required'],
        [['description', 'photo_url', 'contacts'], 'string'],
        [['price'], 'number'],
        [['year'], 'number']
    ];
}

    public function getOptions()
    {
        return $this->hasMany(CarOption::class, ['car_id' => 'id']);
    }
    public function fields()
{
    return [
        'id',
        'title',
        'description',
        'year',
        'price',
        'photo_url',
        'contacts',
        'options'
    ];
}
public function extraFields()
{
    return ['options'];
}
}
