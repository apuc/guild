<?php

use yii\db\Migration;

/**
 * Class m211109_084732_changing_foreign_key_in_user_response_from_user_questionnaire_id_to_user_questionnaire_uuid
 */
class m211109_084732_changing_foreign_key_in_user_response_from_user_questionnaire_id_to_user_questionnaire_uuid extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('questionnaire_response', 'user_response');
        $this->renameColumn('user_response', 'user_questionnaire_id', 'user_questionnaire_uuid');
        $this->alterColumn('user_response', 'user_questionnaire_uuid', 'varchar(36)');
        $this->addForeignKey(
            'questionnaire_response',
            'user_response',
            'user_questionnaire_uuid',
            'user_questionnaire',
            'uuid'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('questionnaire_response', 'user_response');
        $this->alterColumn('user_response', 'user_questionnaire_uuid', 'int');
        $this->renameColumn('user_response', 'user_questionnaire_uuid', 'user_questionnaire_id');
        $this->addForeignKey(
            'questionnaire_response',
            'user_response',
            'user_questionnaire_id',
            'user_questionnaire',
            'id'
        );
    }
}
