<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102202_create_chat_subcategory_translation_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_subcategory_translation', [
            'id' => $this->primaryKey(),
            'sub_cat_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('chat_subcategory_translation-chat_subcategory-FK', 'chat_subcategory_translation',
            'sub_cat_id', 'chat_subcategory', 'id');
        $this->addForeignKey('chat_subcategory_translation_language_FK', 'chat_subcategory_translation',
            'language_id', 'language', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('chat_subcategory_translation-chat_subcategory-FK', 'chat_subcategory_translation');
        $this->dropForeignKey('chat_subcategory_translation_language_FK', 'chat_subcategory_translation');

        $this->dropTable('chat_subcategory_translation');
    }
}
