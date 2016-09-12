<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102513_create_chat_category_param_item_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_category_param_item', [
            'id' => $this->primaryKey(),
            'param_id' => $this->integer()->notNull(),
            'priority' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('chat_category_param_item-chat_category_param-FK', 'chat_category_param_item',
            'param_id', 'chat_category_param', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_category_param_item-chat_category_param-FK', 'chat_category_param_item');

        $this->dropTable('chat_category_param_item');
    }
}
