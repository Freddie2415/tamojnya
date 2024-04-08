<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cars}}`.
 */
class m240330_101528_create_cars_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cars', [
            'id' => $this->primaryKey(),
            'car_number'=>$this->string(),
            'country_id'=>$this->integer(),
            'model'=>$this->string(),
            'phoneNumber'=>$this->string(),
            'arrivedDate'=>$this->dateTime(),
            'departureDate'=>$this->dateTime(),
            'status'=>'ENUM("accepted", "denied", "in Progress")',
            'cost'=>$this->float()
        ],);

          // creates index for column `country_id`
          $this->createIndex(
            'idx-cars-country_id',
            'cars',
            'country_id'
        );

        // add foreign key for table `{{%countries}}`
        $this->addForeignKey(
            'fk-cars-country_id',
            'cars',
            'country_id',
            'countries',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%countries}}`
        $this->dropForeignKey(
            'fk-cars-country_id',
            'cars'
        );

        // drops index for column `country_id`
        $this->dropIndex(
            'idx-cars-country_id',
            'cars'
        );
        $this->dropTable('cars');
    }
}
