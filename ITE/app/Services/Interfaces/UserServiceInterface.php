<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface UserServiceInterface
{
    /**
     * find user by name
     *
     * @param string $name
     * @return User
     * @throws ModelNotFoundException
     */
    public function findByName(string $name): User;

    /**
     * find user by id
     *
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function findById(int $id): User;

    /**
     * Create a new user.
     *
     * @param $data.
     * @return User
     * @throws ValidationException
     */
    public function createUser($data): User;

    /**
     * Update user information.
     *
     * @param int $id
     * @param $data
     * @return User
     * @throws ModelNotFoundException
     */
    public function updateUser(int $id, $data): User;

    /**
     * Change the user's password.
     *
     * @param int $id
     * @param string $newPassword
     * @throws ModelNotFoundException
     */
    public function changeUserPassword(int $id, string $newPassword);

    /**
     * Create token.
     *
     * @param array $data
     */
    public function createToken(array $data);
}
