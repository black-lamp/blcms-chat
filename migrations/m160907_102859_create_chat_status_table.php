<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_102859_create_chat_status_table extends Migration
{
    public function up()
    {
        $this->createTable('chat_status', [
            'id' => $this->primaryKey()
        ]);
    }

    public function down()
    {
        $this->dropTable('chat_status');
    }
}
