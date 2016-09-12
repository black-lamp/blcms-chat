<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102130_create_chat_subcategory_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_subcategory', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'priority' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('chat_subcategory-chat_category-FK', 'chat_subcategory', 'category_id', 'chat_category', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_subcategory-chat_category-FK', 'chat_subcategory');

        $this->dropTable('chat_subcategory');
    }
}
