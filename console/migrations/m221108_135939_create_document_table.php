<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%document}}`.
 */
class m221108_135939_create_document_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%document}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(11)->notNull(),
            'contractor_company_id' => $this->integer(11),
            'manager_id' => $this->integer(11)->notNull(),
            'contractor_manager_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey('company_document', 'document', 'company_id', 'company', 'id');
        $this->addForeignKey('contractor_company_document', 'document', 'contractor_company_id', 'company', 'id');
        $this->addForeignKey('manager_document', 'document', 'manager_id','manager', 'id');
        $this->addForeignKey('contractor_manager_document', 'document', 'contractor_manager_id','manager', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%document}}');
    }
}
