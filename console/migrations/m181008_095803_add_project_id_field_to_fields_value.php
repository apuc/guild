<?php

use yii\db\Migration;

/**
 * Class m181008_095803_add_project_id_field_to_fields_value
 */
class m181008_095803_add_project_id_field_to_fields_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('fields_value', 'project_id', $this->integer(11));
        $this->alterColumn('fields_value', 'card_id', $this->integer(11));

        $this->addForeignKey(
            'fields_value_ibfk_project',
            'fields_value',
            'project_id',
            'project',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fields_value_ibfk_project', 'fields_value');

        $this->dropColumn('fields_value', 'project_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181008_095803_add_project_id_field_to_fields_value cannot be reverted.\n";

        return false;
    }
    */
}
