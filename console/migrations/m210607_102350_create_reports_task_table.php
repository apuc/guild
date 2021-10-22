<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reports_task}}`.
 */
class m210607_102350_create_reports_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reports_task}}', [
            'id' => $this->primaryKey(),
            'report_id' => $this->integer(11)->notNull(),
            'task' => $this->text(),
            'hours_spent' => $this->float(6),
            'created_at' => $this->integer(11),
            'status' => $this->integer(1),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-reports_task-report_id',
            'reports_task',
            'report_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-reports_task-report_id',
            'reports_task',
            'report_id',
            'reports',
            'id',
            'CASCADE'
        );

        $this->alterColumn('reports', 'today', $this->text());
        $this->alterColumn('reports', 'difficulties', $this->text());
        $this->alterColumn('reports', 'tomorrow', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-reports_task-report_id',
            'reports_task'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-reports_task-report_id',
            'reports_task'
        );

        $this->alterColumn('reports', 'today', $this->string(255)->notNull());
        $this->alterColumn('reports', 'difficulties', $this->string(255));
        $this->alterColumn('reports', 'tomorrow', $this->string(255));

        $this->dropTable('{{%reports_task}}');
    }


}
