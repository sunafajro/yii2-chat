<?php

class m211205_201700_create_chat_messages_table extends \yii\db\Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('chat_messages', [
            'id'             => $this->primaryKey(),
            'user_id'        => $this->integer()->notNull(),
            'room_id'        => $this->integer()->notNull(),
            'type'           => $this->string(),
            'body'           => $this->text(),
            'status'         => $this->string()->notNull(),
            'mentioned_to'   => 'jsonb',
            'replied_to'     => $this->integer(),
            'created_at'     => $this->timestamp(),
            'updated_at'     => $this->timestamp(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('chat_messages');
    }
}