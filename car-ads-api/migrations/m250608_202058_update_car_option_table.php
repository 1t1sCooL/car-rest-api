<?php

use yii\db\Migration;

class m250608_202058_update_car_option_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250608_202058_update_car_option_table cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $this->addColumn('car_option','brand', $this->string()->notNull());
        $this->addColumn('car_option','model', $this->string()->notNull());
        $this->addColumn('car_option','year', $this->integer()->notNull());
        $this->addColumn('car_option','body', $this->string()->notNull());
        $this->addColumn('car_option','mileage', $this->integer()->notNull());
    }

    public function down()
    {
        echo "m250608_202058_update_car_option_table cannot be reverted.\n";

        return false;
    }
}
