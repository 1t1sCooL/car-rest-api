<?php

use yii\db\Migration;

class m230101_123456_create_car_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('car', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'price' => $this->decimal(10, 2)->notNull(),
            'photo_url' => $this->string(),
            'contacts' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        
        $this->createTable('car_option', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer()->notNull(),
            'brand' => $this->string()->notNull(),
            'model' => $this->string()->notNull(),
            'year' => $this->integer()->notNull(),
            'body' => $this->string()->notNull(),
            'mileage' => $this->integer()->notNull(),
        ]);
        
        $this->addForeignKey(
            'fk-car_option-car_id',
            'car_option',
            'car_id',
            'car',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('car_option');
        $this->dropTable('car');
    }
}