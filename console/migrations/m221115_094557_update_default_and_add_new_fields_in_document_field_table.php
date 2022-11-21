<?php

use common\models\DocumentField;
use yii\db\Migration;

/**
 * Class m221115_094557_add_update_default_and_add_new_fields_in_document_field_table
 */
class m221115_094557_update_default_and_add_new_fields_in_document_field_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $documentFields = DocumentField::find()->all();
        foreach ($documentFields as $documentField) {
            $documentField->field_template = '${' . $documentField->field_template . '}';
            $documentField->update();
        }

        Yii::$app->db->createCommand()->batchInsert('document_field', [ 'title', 'field_template'],
            [
                ['№ договора', '${contract_number}'],
                ['Название', '${title}'],
                ['Компания', '${company}'],
                ['Представитель', '${manager}'],
                ['Компания контрагент', '${contractor_company}'],
                ['Представитель контрагента', '${contractor_manager}']
            ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->delete('document_field',
            [
                'in', 'title', [
                '№ договора',
                'Название',
                'Компания',
                'Представитель',
                'Компания контрагент',
                'Представитель контрагента',
            ]
            ])->execute();

        $documentFields = DocumentField::find()->all();
        foreach ($documentFields as $documentField) {
            $documentField->field_template = str_replace(['${', '}'], '', $documentField->field_template);
            $documentField->update();
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221115_094557_add_update_default_andaddnewfieldsin_document_field_table cannot be reverted.\n";

        return false;
    }
    */
}
