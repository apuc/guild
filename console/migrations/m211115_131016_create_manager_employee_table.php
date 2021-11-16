<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manager_employee}}`.
 */
class m211115_131016_create_manager_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%manager_employee}}', [
            'id' => $this->primaryKey(),
            'manager_id' => $this->integer(),
            'employee_id' => $this->integer(),
        ]);
        $this->addForeignKey('manager_employee', 'manager_employee', 'manager_id', 'manager', 'id');
        $this->addForeignKey('employee_user', 'manager_employee', 'employee_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('manager_employee', 'manager_employee');
        $this->dropForeignKey('employee_user', 'manager_employee');
        $this->dropTable('{{%manager_employee}}');
    }
}
