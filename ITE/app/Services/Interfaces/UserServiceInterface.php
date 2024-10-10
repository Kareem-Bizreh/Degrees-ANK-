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
    public function findById(int $id);

    /**
     * Create a new user.
     *
     * @param $data.
     * @return User
     * @throws ValidationException
     */
    public function createUser($data);

    /**
     * Update user information.
     *
     * @param int $id
     * @param $data
     * @return User
     * @throws ModelNotFoundException
     */
    public function updateUser(int $id, $data);

    /**
     * Change the user's password.
     *
     * @param int $id
     * @param string $newPassword
     * @throws ModelNotFoundException
     * @return bool
     */
    public function changeUserPassword(int $id, string $newPassword): bool;

    /**
     * Create token.
     *
     * @param array $data
     */
    public function createToken(array $data);

    /**
     * set specialization for some year
     *
     * @param string $academic_year
     * @param string $user_name
     * @param string $specialization
     * @return bool
     */
    function setSpecialization(string $academic_year, string $user_name, string $specialization): bool;

    /**
     * get specialization in some year
     *
     * @param string $academic_year
     * @param string $user_name
     * @return string
     */
    function getSpecialization(string $academic_year, string $user_name): string;
}
