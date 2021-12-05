<?php

class m211205_202400_create_chat_users_table extends \yii\db\Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('chat_users', [
            'id'           => $this->primaryKey(),
            'display_name' => $this->text(),
            'status'       => $this->string()->notNull(),
            'created_at'   => $this->timestamp(),
            'updated_at'   => $this->timestamp(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('chat_users');
    }
}