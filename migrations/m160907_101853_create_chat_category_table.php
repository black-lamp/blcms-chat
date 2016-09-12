<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_101853_create_chat_category_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_category', [
            'id' => $this->primaryKey()
        ]);
    }

    public function down()
    {
        $this->dropTable('chat_category');
    }
}
