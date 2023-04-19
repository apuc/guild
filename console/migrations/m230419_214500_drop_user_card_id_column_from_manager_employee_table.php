<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%manager_employee}}`.
 */
class m230419_214500_drop_user_card_id_column_from_manager_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('manager_employee_user_card', 'manager_employee');
        $this->dropColumn('manager_employee', 'user_card_id');

        $this->addColumn('manager_employee', 'employee_id', $this->integer(11));
        $this->addForeignKey('employee_user', 'manager_employee', 'employee_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('manager_employee', 'user_card_id', $this->integer(11));
        $this->addForeignKey('manager_employee_user_card', 'manager_employee', 'user_card_id',
            'user_card', 'id');

        $this->dropForeignKey('employee_user', 'manager_employee');
        $this->dropColumn('manager_employee', 'employee_id');
    }
}
