<?php

namespace App\Services\Classes;

use App\Enums\Specialization;
use App\Services\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserService implements UserServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * find user by id
     *
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function findById(int $id): User
    {
        return User::find($id);
    }

    /**
     * find user by name
     *
     * @param string $name
     * @return User
     * @throws ModelNotFoundException
     */
    public function findByName(string $name): User
    {
        return User::where('name', $name)->get()->first();
    }

    /**
     * Create a new user.
     *
     * @param $data.
     * @return User
     * @throws ValidationException
     */
    public function createUser($data): User
    {
        $user = new User;
        $user->name = $data['name'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->entry_year = $data['entry_year'];
        $user->password = bcrypt($data['password']);
        $user->save();
        DB::table('competitors')->insert([
            'student_id' => $user->id,
            'friend_id' => $user->id
        ]);
        return $user;
    }

    /**
     * Update user information.
     *
     * @param int $id
     * @param $data
     * @return User
     * @throws ModelNotFoundException
     */
    public function updateUser(int $id, $data): User
    {
        $user = User::find($id);
        $user->update($data);
        $user->save();
        return $user;
    }

    /**
     * Change the user's password.
     *
     * @param int $id
     * @param string $newPassword
     * @throws ModelNotFoundException
     */
    public function changeUserPassword(int $id, string $newPassword)
    {
        $user = $this->findById($id);
        $user->password = bcrypt($newPassword);
        $user->save();
    }

    /**
     * Create token.
     *
     * @param array $data
     */
    public function createToken(array $data)
    {
        $token = JWTAuth::attempt($data);
        if (! $token) {
            return response()->json([
                'message' => 'user login failed'
            ], 400);
        }
        return response()->json([
            'message' => 'user has been login successfuly',
            'Bearer Token' => $token
        ], 200);
    }
}
