<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "countries".
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ru
 * @property string|null $name_uz
 *
 * @property Cars[] $cars
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_en', 'name_ru', 'name_uz'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_en' => 'Name En',
            'name_ru' => 'Name Ru',
            'name_uz' => 'Name Uz',
        ];
    }
    public static function fetchData()
    {
        if(Yii::$app->language=='ru'){
            return ArrayHelper::map(
                self::find()->all(),
                'id',
                'name_ru'
            );
        }else if(Yii::$app->language=='uz'){
            return ArrayHelper::map(
                self::find()->all(),
                'id',
                'name_uz'
            );
        }else{
            return ArrayHelper::map(
                self::find()->all(),
                'id',
                'name_en'
            );
        }
       
    }
    /**
     * Gets query for [[Cars]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCars()
    {
        return $this->hasMany(Cars::class, ['country_id' => 'id']);
    }
}
