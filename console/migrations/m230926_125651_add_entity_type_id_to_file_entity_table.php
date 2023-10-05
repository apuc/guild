<?php

use yii\db\Migration;

/**
 * Class m230926_125651_add_entity_type_id_to_file_entity_table
 */
class m230926_125651_add_entity_type_id_to_file_entity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('file_entity', 'entity_type', 'entity_type_id');

        $this->alterColumn('file_entity', 'entity_type_id', $this->integer(11));

        $this->addForeignKey('entity_type_id_foreign', 'file_entity', 'entity_type_id', 'entity_type', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('entity_type_id_foreign', 'file_entity');

        $this->alterColumn('file_entity', 'entity_type_id', $this->integer(2));

        $this->renameColumn('file_entity', 'entity_type_id', 'entity_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230926_125651_add_entity_type_id_to_file_entity_table cannot be reverted.\n";

        return false;
    }
    */
}
