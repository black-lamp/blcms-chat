<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_101941_create_chat_category_translation_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_category_translation', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull()
        ]);

        $this->addForeignKey('chat_category_translation-chat_category-FK', 'chat_category_translation',
            'category_id', 'chat_category', 'id');
        $this->addForeignKey('chat_category_translation-language-FK', 'chat_category_translation',
            'language_id', 'language', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_category_translation-chat_category-FK', 'chat_category_translation');
        $this->dropForeignKey('chat_category_translation-language-FK', 'chat_category_translation');

        $this->dropTable('chat_category_translation');
    }
}
