<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102958_create_chat_user_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_user', [
            'id' => $this->primaryKey(),
            'chat_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->defaultValue(1),
            'date_create' => $this->integer()->notNull(),
            'date_update' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('chat_user-chat-FK', 'chat_user', 'chat_id', 'chat', 'id');
        $this->addForeignKey('chat_user-chat_status-FK', 'chat_user', 'status_id', 'chat_status', 'id');

        $this->createIndex('chat_user-chat_id-IDX', 'chat_user', 'chat_id');
        $this->createIndex('chat_user-user_id-IDX', 'chat_user', 'user_id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_user-chat-FK', 'chat_user');
        $this->dropForeignKey('chat_user-chat_status-FK', 'chat_user');

        $this->dropIndex('chat_user-chat_id-IDX', 'chat_user');
        $this->dropIndex('chat_user-user_id-IDX', 'user_user');

        $this->dropTable('chat_user');
    }
}
