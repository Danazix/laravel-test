<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    /**
     * Get user list
     *
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function list(int $page, int $perPage): array
    {
        return User::forPage($page, $perPage)->get()->toArray();
    }

    /**
     * Get users count
     *
     * @return int
     */
    public function count()
    {
        return User::count();
    }

    /**
     * Get user by id
     *
     * @param int $id
     * @return array
     */
    public function get(int $id): array
    {
        return User::findOrFail($id)->toArray();
    }

    /**
     * Update user
     *
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        $user = User::findOrFail($id);
        $user->fill($data);
        return $user->save();
    }
}
