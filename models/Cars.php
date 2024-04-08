<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cars".
 *
 * @property int $id
 * @property string|null $car_number
 * @property int|null $country_id
 * @property string|null $model
 * @property string|null $phoneNumber
 * @property string|null $arrivedDate
 * @property string|null $departureDate
 * @property string|null $status
 * @property float|null $cost
 *
 * @property Countries $country
 */
class Cars extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cars';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id'], 'integer'],
            [['arrivedDate', 'departureDate'], 'safe'],
            [['status'], 'string'],
            [['cost'], 'number'],
            [['car_number', 'model', 'phoneNumber'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'country_id' => 'Страна автомобиля',
            'car_number' => 'Номер автомобиля',
            'model' => 'Марка автомобиля',
            'phoneNumber' => 'Номер Телефона',
            'arrivedDate' => 'Дата въезда',
            'departureDate' => 'Дата выезда',
            'status' => 'Статус',
            'cost' => 'Стоимсть',
        ];
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::class, ['id' => 'country_id']);
    }
}
