<?php

namespace App\Http\Controllers;

use App\Enums\AcademicYear;
use App\Enums\Specialization;
use App\Services\Classes\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

/**
 * @OA\Info(title="My First API", version="0.1")
 */
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/users/register",
     *     summary="register users",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "first_name" , "last_name" , "entry_year" , "password" , "password_confirmation"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Harry Potter"
     *             ),
     *             @OA\Property(
     *                 property="first_name",
     *                 type="string",
     *                 example="Harry"
     *             ),
     *             @OA\Property(
     *                 property="last_name",
     *                 type="string",
     *                 example="Potter"
     *             ),
     *             @OA\Property(
     *                 property="entry_year",
     *                 type="string",
     *                 example="2022"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password"
     *             ),
     *             @OA\Property(
     *                 property="password_confirmation",
     *                 type="string",
     *                 example="password"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successful register",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="user succesfully register"
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function register(Request $request)
    {
        $validateDate = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'entry_year' => 'required|digits:4',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validateDate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validateDate->errors(),
            ], 400);
        }
        $validateDate = $validateDate->validated();
        $user = $this->userService->createUser($validateDate);
        return response()->json(['message' => 'user succesfully register'], 200);
    }

    /**
     * @OA\Post(
     *     path="/users/login",
     *     summary="login user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "password"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Harry Potter"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successful login",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="user has been login successfuly"
     *             ),
     *             @OA\Property(
     *                 property="Bearer Token",
     *                 type="string",
     *                 example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function login(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|exists:users,name',
            'password' => 'required|string|min:8',
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $data->errors(),
            ], 400);
        }
        $data = $data->validated();

        $user = $this->userService->findByName($data['name']);
        if (! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'the password is not correct',
            ], 400);
        }

        return $this->userService->createToken($data);
    }

    /**
     * @OA\Post(
     *     path="/users/logout",
     *     summary="logout user",
     *     tags={"Users"},
     *     @OA\Response(
     *      response=200, description="Successful logout",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="user has been logout successfuly"
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request"),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'user has been logout successfuly'
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/users/setPassword",
     *     summary="set new password",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "password" , "password_confirmation"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Harry Potter"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password123"
     *             ),
     *             @OA\Property(
     *                 property="password_confirmation",
     *                 type="string",
     *                 example="password123"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successfully set of password",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="new password set"
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function setPassword(Request $request)
    {
        $data = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
            'name' => 'required|string|max:20'
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $data->errors(),
            ], 400);
        }
        $data = $data->validated();

        $this->userService->changeUserPassword($this->userService->findByName($data['name'])->id, $data['password']);

        return response()->json([
            'message' => 'new password set'
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/users/resetPassword",
     *     summary="reset password",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"old_password", "new_password" , "new_password_confirmation"},
     *             @OA\Property(
     *                 property="old_password",
     *                 type="string",
     *                 example="password"
     *             ),
     *             @OA\Property(
     *                 property="new_password",
     *                 type="string",
     *                 example="password123"
     *             ),
     *             @OA\Property(
     *                 property="new_password_confirmation",
     *                 type="string",
     *                 example="password123"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successfully set of password",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="new password set"
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request"),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */
    public function resetPassword(Request $request)
    {
        $data = Validator::make($request->all(), [
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $data->errors(),
            ], 400);
        }
        $data = $data->validated();

        $user = $this->userService->findById(Auth::id());

        if (! Hash::check($data['old_password'], $user->password)) {
            return response()->json([
                'message' => 'the password is not correct',
            ], 400);
        }

        $this->userService->changeUserPassword($user->id, $data['new_password']);

        return response()->json([
            'message' => 'new password set'
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/users/editUser",
     *     summary="edit users",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "first_name" , "last_name" , "specialization"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Ron Weasly"
     *             ),
     *             @OA\Property(
     *                 property="first_name",
     *                 type="string",
     *                 example="Ron"
     *             ),
     *             @OA\Property(
     *                 property="last_name",
     *                 type="string",
     *                 example="Weasly"
     *             ),
     *             @OA\Property(
     *                 property="specialization",
     *                 type="string",
     *                 example="AI"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successfully edit the user",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="updated done"
     *             ),
     *             @OA\Property(
     *                 property="user",
     *                 type="string",
     *                 example="[]"
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request"),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */
    public function edit(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'specialization' => ['required', new Enum(Specialization::class)]
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $data->errors(),
            ], 400);
        }
        $data = $data->validated();

        $user = $this->userService->updateUser(Auth::id(), $data);

        return response()->json([
            'message' => 'updated done',
            'user' => $user
        ]);
    }

    /**
     * @OA\Put(
     *     path="/users/setSpecialization",
     *     summary="set specialization for user in some year",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"specialization", "academic_year", "name"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Harry Potter"
     *             ),
     *             @OA\Property(
     *                 property="specialization",
     *                 type="string",
     *                 example="AI"
     *             ),
     *             @OA\Property(
     *                 property="academic_year",
     *                 type="string",
     *                 example="fourth_year"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successfully set the specialization",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="updated done"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request"),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */
    function setSpecialization(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|exists:users,name',
            'specialization' => ['required', new Enum(Specialization::class)],
            'academic_year' => ['required', new Enum(AcademicYear::class)]
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $data->errors(),
            ], 400);
        }
        $data = $data->validated();

        $user = $this->userService->setSpecialization($data['academic_year'], $data['name'], $data['specialization']);

        return response()->json(['message' => 'updated done']);
    }

    /**
     * @OA\Get(
     *     path="/users/currentUser",
     *     summary="current user information",
     *     tags={"Users"},
     *     @OA\Response(
     *      response=200, description="return the user"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function current()
    {
        return response()->json(['user' => Auth::user()]);
    }

    /**
     * @OA\Get(
     *     path="/users/getUser/{name}",
     *     summary="get user information",
     *     tags={"Users"},
     *     @OA\Parameter(
     *            name="name",
     *            in="path",
     *            required=true,
     *            description="user name",
     *            @OA\Schema(
     *                type="string"
     *            )
     *        ),
     *     @OA\Response(
     *      response=200, description="return the user"),
     *     @OA\Response(response=400, description="Invalid request"),
     * )
     */
    public function getUser(string $name)
    {
        return response()->json(['user' => $this->userService->findByName($name)]);
    }

    /**
     * @OA\Get(
     *     path="/users/getSpecialization/{academic_year}/{user_name}",
     *     summary="get user specialization in some year",
     *     tags={"Users"},
     *     @OA\Parameter(
     *            name="academic_year",
     *            in="path",
     *            required=true,
     *            description="academic year",
     *            example="fourth_year",
     *            @OA\Schema(
     *                type="string"
     *            )
     *        ),
     *     @OA\Parameter(
     *            name="user_name",
     *            in="path",
     *            required=true,
     *            description="user name",
     *            example="Harry Potter",
     *            @OA\Schema(
     *                type="string"
     *            )
     *     ),
     *     @OA\Response(
     *      response=200, description="return the users specialization"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function getSpecialization(string $academic_year, string $user_name)
    {
        return response()->json([
            'specialization' => $this->userService->getSpecialization($academic_year, $user_name)
        ]);
    }
}
