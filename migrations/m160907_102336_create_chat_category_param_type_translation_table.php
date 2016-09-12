<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102336_create_chat_category_param_type_translation_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_category_param_type_translation', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()
        ]);

        $this->addForeignKey('chat_category_param_type_translation-chat_category_param_type-FK',
            'chat_category_param_type_translation', 'type_id', 'chat_category_param_type', 'id');
        $this->addForeignKey('chat_category_param_type_translation_language_FK', 'chat_category_param_type_translation',
            'language_id', 'language', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_category_param_type_translation-chat_category_param_type-FK',
            'chat_category_param_type_translation');
        $this->dropForeignKey('chat_category_param_type_translation_language_FK', 'chat_category_param_type_translation');

        $this->dropTable('chat_category_param_type_translation');
    }
}
