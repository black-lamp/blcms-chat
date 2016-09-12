<?php

use yii\db\Migration;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class m160907_103121_add_data_to_chat_status_table extends Migration
{
    public function up()
    {
        $this->batchInsert('chat_status', ['id'], [
            [ 1 ],
            [ 2 ]
        ]);
    }

    public function down()
    {
        return true;
    }
}
