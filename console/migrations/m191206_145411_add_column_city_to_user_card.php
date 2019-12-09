<?php

use yii\db\Migration;

/**
 * Class m191206_145411_add_column_city_to_user_card
 */
class m191206_145411_add_column_city_to_user_card extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_card', 'city', $this->string(255));

//        $this->addColumn('user_card', 'city', $this->integer(11)->notNull()->defaultValue('1'));
//        $this->addForeignKey(
//            'city',
//            'user_card',
//            'city',
//            'cities',
//            'id',
//            'RESTRICT',
//            'CASCADE'
//        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('cityID', 'user_card');
        $this->dropColumn('user_card', 'city');
    }
}
