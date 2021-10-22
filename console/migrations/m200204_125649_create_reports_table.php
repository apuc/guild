<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reports}}`.
 */
class m200204_125649_create_reports_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reports}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->date()->notNull(),
            'today' => $this->string()->notNull(),
            'difficulties' => $this->string(),
            'tomorrow' => $this->string(),
            'status' => $this->integer()
        ]);

        $this->addColumn('{{%reports}}', 'user_card_id', $this->integer()->notNull());

        // creates index for column `user_card_id`
        $this->createIndex(
            '{{%idx-reports-user_card_id}}',
            '{{%reports}}',
            'user_card_id'
        );

        // add foreign key for table `{{%user_card}}`
        $this->addForeignKey(
            '{{%fk-reports-user_card_id}}',
            '{{%reports}}',
            'user_card_id',
            '{{%user_card}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%reports}}');
    }
}
