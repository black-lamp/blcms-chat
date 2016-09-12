<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102042_create_chat_table extends Migration
{
    public function up()
    {
        $this->createTable('chat', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'creator_id' => $this->integer()->notNull(),
            'date_create' => $this->integer()->notNull(),
            'date_update' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('chat-chat_category-FK', 'chat', 'category_id', 'chat_category', 'id');
        $this->createIndex('chat-id-IDX', 'chat', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat-chat_category-FK', 'chat');
        $this->dropIndex('chat-id-IDX', 'chat');

        $this->dropTable('chat');
    }
}
