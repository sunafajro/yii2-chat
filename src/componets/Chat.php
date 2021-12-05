<?php

namespace sunafajro\chat\components;

use sunafajro\chat\models\LastRead;
use sunafajro\chat\models\Message;
use sunafajro\chat\models\Room;
use sunafajro\chat\models\User;
use yii\base\Component;

class Chat extends Component
{
    /**
     * @return int
     * @throws \Exception
     */
    public function createRoom(): int
    {
        $room = new Room();
        if (!$room->save()) {
            throw new \Exception('Не удалось создать новую комнату для чата.');
        }

        return $room->id;
    }

    /**
     * @param string $displayName
     * @return int
     * @throws \Exception
     */
    public function createUser(string $displayName): int
    {
        $user = new User(['displayName' => $displayName]);
        if (!$user->save()) {
            throw new \Exception('Не удалось создать нового пользователя для чата.');
        }

        return $user->id;
    }

    /**
     * @param int $roomId
     * @param array $userIds
     * @return bool
     * @throws \Exception
     */
    public function syncRoomUsers(int $roomId, array $userIds): bool
    {
        try {
            $room = $this->getRoom($roomId);
            $room->unlinkAll('users', true);
            if (!empty($userIds)) {
                $users = User::find()->where(['id' => $userIds]);
                foreach ($users->each() as $user) {
                    $room->link('users', $user);
                }
            }
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Не удалось найти комнату чата №{$roomId}.");
        }
    }

    public function sendMessage(int $userId, int $roomId, string $body, int $repliedTo = null): int
    {
        try {
            $room = $this->getRoom($roomId);
            $user = $this->getUser($userId);
            $message = new Message([
                'user_id' => $userId,
                'room_id' => $roomId,
                'type'    => Message::TYPE_USER,
                'replied_to' => $repliedTo,
            ]);
            if (!$message->save()) {
                throw new \Exception();
            }
            return $message->id;
        } catch (\Exception $e) {
            throw new \Exception("Не удалось создать новое сообщение.");
        }
    }

    /**
     * @param int $id
     * @return Room
     * @throws \Exception
     */
    public function getRoom(int $id): Room
    {
        /** @var Room $room|null */
        $room = Room::find()->where(["id" => $id])->one();
        if (empty($room)) {
            throw new \Exception("Не удалось найти комнату чата №{$id}.");
        }

        return $room;
    }

    /**
     * @param int $id
     * @return Message
     * @throws \Exception
     */
    public function getMessage(int $id)
    {
        /** @var Message|null $message */
        $message = Message::find()->where(["id" => $id])->one();
        if (empty($message)) {
            throw new \Exception("Не удалось найти сообщение чата №{$id}.");
        }

        return $message;
    }

    /**
     * @param int $id
     * @return User
     * @throws \Exception
     */
    public function getUser(int $id)
    {
        /** @var User|null $user */
        $user = User::find()->where(["id" => $id])->one();
        if (empty($user)) {
            throw new \Exception("Не удалось найти пользователя чата №{$id}.");
        }

        return $user;
    }

    /**
     * @param array $params
     * @return Message[]
     */
    public function getMessages(array $params): array
    {
        $messageQuery = Message::find();

        // TODO применить $params

        return $messageQuery->all();
    }

    /**
     * @param int $id
     * @param array $params
     * @return Message[]
     * @throws \Exception
     */
    public function getRoomMessages(int $id, array $params): array
    {
        try {
            $room = $this->getRoom($id);
            $messageQuery = Message::find()->where(['roomId' => $id]);

            // TODO применить $params

            return $messageQuery->all();
        } catch (\Exception $e) {
            throw new \Exception("Не удалось найти сообщения чата для комнаты №{$id}.");
        }
    }

    public function readMessage(int $userId, int $messageId): bool
    {
        try {
            $user = $this->getUser($userId);
            $message = $this->getMessage($messageId);

            $lastRead = new LastRead([
                'user_id' => $userId,
                'room_id' => $message->room_id,
                'message_id' => $message->id,
            ]);
            if (!$lastRead->save()) {
                throw new \Exception();
            }

            return true;
        } catch (\Exception $e) {
            throw new \Exception("Не удалось создать отметку о прочтении для сообщения №{$messageId}.");
        }
    }
}
