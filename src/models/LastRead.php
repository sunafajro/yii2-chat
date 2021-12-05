<?php

namespace sunafajro\chat\models;

use yii\behaviors\TimestampBehavior;

/**
 * @property int    $id
 * @property int    $user_id
 * @property int    $room_id
 * @property int    $message_id
 * @property string $created_at
 * @property string $updated_at
 */
class LastRead extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'chat_last_reads';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules(): array
    {
        return [
            [['user_id', 'room_id', 'message_id'], 'integer'],
            [['user_id', 'room_id', 'message_id'], 'required'],
        ];
    }
}