<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_card}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m191114_124130_add_id_user_column_to_user_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_card}}', 'id_user', $this->integer());

        // creates index for column `id_user`
        $this->createIndex(
            '{{%idx-user_card-id_user}}',
            '{{%user_card}}',
            'id_user'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_card-id_user}}',
            '{{%user_card}}',
            'id_user',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_card-id_user}}',
            '{{%user_card}}'
        );

        // drops index for column `id_user`
        $this->dropIndex(
            '{{%idx-user_card-id_user}}',
            '{{%user_card}}'
        );

        $this->dropColumn('{{%user_card}}', 'id_user');
    }
}
