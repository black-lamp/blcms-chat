<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102821_create_chat_message_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_message', [
            'id' => $this->primaryKey(),
            'chat_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'moderation' => $this->boolean()->defaultValue(true),
            'date_create' => $this->integer()->notNull(),
            'date_update' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('chat_message-chat-FK', 'chat_message', 'chat_id', 'chat', 'id');

        $this->createIndex('chat_message-chat_id-IDX', 'chat_message', 'chat_id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_message-chat-FK', 'chat_message');

        $this->dropIndex('chat_message-chat_id-IDX', 'chat_message');

        $this->dropTable('chat_message');
    }
}
