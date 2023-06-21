<?php

use yii\db\Migration;

/**
 * Class m230526_105126_create_file_entity_teble
 */
class m230526_105126_create_file_entity_teble extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%file_entity}}', [
            'id' => $this->primaryKey(),
            'file_id' => $this->integer(11),
            'entity_type' => $this->integer(2),
            'entity_id' => $this->integer(11),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'status' => $this->integer(1)->defaultValue(1),
        ]);

        $this->addForeignKey('fk_file_entity_file', 'file_entity', 'file_id', 'file', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_file_entity_file', 'file_entity');
        $this->dropTable('{{%file_entity}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230526_105126_create_file_entity_teble cannot be reverted.\n";

        return false;
    }
    */
}
