<?php

use yii\db\Migration;

/**
 * Class m211222_083709_change_foreign_key_in_manager_employee_from_user_id_to_user_card_id
 */
class m211222_083709_change_foreign_key_in_manager_employee_from_user_id_to_user_card_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('employee_user', 'manager_employee');
        $this->dropColumn('manager_employee', 'employee_id');

        $this->addColumn('manager_employee', 'user_card_id', $this->integer(11));
        $this->addForeignKey('manager_employee_user_card', 'manager_employee', 'user_card_id',
            'user_card', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('manager_employee_user_card', 'manager_employee');
        $this->dropColumn('manager_employee', 'user_card_id');

        $this->addColumn('manager_employee', 'employee_id', $this->integer(11));
        $this->addForeignKey('employee_user', 'manager_employee', 'employee_id', 'user', 'id');
    }
}
