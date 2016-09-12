<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102923_create_chat_status_translation_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_status_translation', [
            'id' => $this->primaryKey(),
            'status_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull()
        ]);

        $this->addForeignKey('chat_status_translation-chat_status-FK',
            'chat_status_translation', 'status_id', 'chat_status', 'id');
        $this->addForeignKey('chat_message_status_translation-language-FK', 'chat_status_translation',
            'language_id', 'language', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_status_translation-chat_status-FK',
            'chat_status_translation');
        $this->dropForeignKey('chat_status_translation-language-FK', 'chat_status_translation');

        $this->dropTable('chat_status_translation');
    }
}
