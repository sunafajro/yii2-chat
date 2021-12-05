<?php

class m211205_202700_create_chat_room_users_table extends \yii\db\Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('chat_room_users', [
            'user_id' => $this->integer(),
            'room_id' => $this->integer(),
        ]);
        $this->addPrimaryKey('pk-user_id-room_id-chat_room_users', 'chat_room_users', ['user_id', 'room_id']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('chat_room_users');
    }
}