<?php

class m211205_195200_create_chat_rooms_table extends \yii\db\Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('chat_rooms', [
            'id'         => $this->primaryKey(),
            'settings'   => 'jsonb',
            'status'     => $this->string()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('chat_rooms');
    }
}