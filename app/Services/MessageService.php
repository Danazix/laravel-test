<?php

namespace App\Services;

use App\Models\Message;
use App\Models\User;

class MessageService
{

    /**
     * Get list quits
     *
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function listQuits(int $page, int $perPage): array
    {
        return Message::quit()->forPage($page, $perPage)->get()->toArray();
    }

    /**
     * Get replies list
     *
     * @param int $messageId
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function listReplies(int $messageId, int $page, int $perPage): array
    {
        return Message::whereParentId($messageId)->forPage($page, $perPage)->get()->toArray();
    }

    /**
     * Create new quit
     *
     * @param $id
     * @param $quitData
     * @return Message|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quit($id, $quitData)
    {
        $user = User::findOrFail($id);

        return $user->messages()->create($quitData);
    }

    /**
     * Create new quit reply
     *
     * @param $id
     * @param int $messageId
     * @param $replyData
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function reply($id, int $messageId, $replyData)
    {
        $user = User::findOrFail($id);

        return Message::quit()->findOrFail($messageId)->replies()
            ->create($replyData + ['user_id' => $user->id]);
    }

    /**
     * Get quit by id
     *
     * @param $id
     * @return array
     */
    public function getQuit($id)
    {
        return Message::quit()->findOrFail($id)->toArray();
    }

    /**
     * Get reply by id
     *
     * @param $quitId
     * @param $id
     * @return array
     */
    public function getReply($quitId, $id)
    {
        return Message::reply()->whereParentId($quitId)->findOrFail($id)->toArray();
    }

    /**
     * Get quits count
     *
     * @return int
     */
    public function countQuits(): int
    {
        return Message::quit()->count();
    }

    /**
     * Get replies count
     *
     * @param int $quitId
     * @return int
     */
    public function countReplies(int $quitId): int
    {
        return Message::quit()->whereParentId($quitId)->count();
    }

    /**
     * Update quit by id
     *
     * @param $userId
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateQuit($userId, $id, $data)
    {
        $message = Message::quit()->whereUserId($userId)->findOrFail($id);
        $message->fill($data);

        return $message->save();
    }

    /**
     * Update reply by id
     *
     * @param $userId
     * @param $quitId
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateReply($userId, $quitId, $id, $data)
    {
        $message = Message::reply()->whereParentId($quitId)->whereUserId($userId)->findOrFail($id);
        $message->fill($data);

        return $message->save();
    }

    /**
     * Delete quit
     *
     * @param $userId
     * @param $id
     * @return bool|mixed|null
     */
    public function deleteQuit($userId, $id)
    {
        return Message::quit()->whereUserId($userId)->findOrFail($id)->delete();
    }

    /**
     * Delete reply
     *
     * @param $userId
     * @param $quitId
     * @param $id
     * @return bool
     */
    public function deleteReply($userId, $quitId, $id)
    {
        $message = Message::reply()->whereParentId($quitId)->findOrFail($id);

        if ($message->user->id === $userId || $message->parent->user->id === $userId) {
            return $message->replies()->delete() && $message->delete();
        }

        return false;
    }
}
