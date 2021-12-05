<?php

class m211205_203400_create_chat_last_reads_table extends \yii\db\Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('chat_last_reads', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer(),
            'room_id'    => $this->integer(),
            'message_id' => $this->integer(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('chat_last_reads');
    }
}