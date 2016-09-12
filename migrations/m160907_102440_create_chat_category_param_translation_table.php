<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102440_create_chat_category_param_translation_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_category_param_translation', [
            'id' => $this->primaryKey(),
            'param_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()
        ]);

        $this->addForeignKey('chat_category_param_translation-chat_category_param-FK', 'chat_category_param_translation',
            'param_id', 'chat_category_param', 'id');
        $this->addForeignKey('chat_category_param_translation-language-FK', 'chat_category_param_translation',
            'language_id', 'language', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_category_param_translation-chat_category_param-FK', 'chat_category_param_translation');
        $this->dropForeignKey('chat_category_param_translation-language-FK', 'chat_category_param_translation');

        $this->dropTable('chat_category_param_translation');
    }
}
