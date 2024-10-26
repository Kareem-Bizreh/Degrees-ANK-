<?php

namespace App\Http\Controllers;

use App\Enums\AcademicYear;
use App\Enums\Specialization;
use App\Services\Classes\MaterialService;
use App\Services\Classes\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class MaterialController extends Controller
{
    protected $materialService, $userService;

    public function __construct(MaterialService $materialService, UserService $userService)
    {
        $this->materialService = $materialService;
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/materials/addDegree",
     *     summary="add degree for",
     *     tags={"Materials"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *         type="array",
     *           @OA\Items(
     *              type="object",
     *              @OA\Property(
     *                  property="material",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="degree",
     *                  type="integer"
     *              )
     *           ),
     *           example={{
     *             "material": "الفيزياء",
     *             "degree": 88,
     *              }, {
     *             "material": "التحليل 1",
     *             "degree": 75,
     *           }}
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successful added",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="degree for material has been added"
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request"),
     *     security={
     *         {"bearer": {}}
     *     }
     * )
     */
    function addDegree(Request $request)
    {
        foreach ($request->all() as $value) {
            $data = Validator::make($value, [
                'material' => 'required|string|exists:materials,name',
                'degree' => 'required|integer|min:0|max:100',
            ]);

            if ($data->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $data->errors(),
                ], 400);
            }
        }
        if ($this->materialService->add($request->all(), Auth::id()))
            return response()->json(['message' => 'degree for material has been added'], 200);
        return response()->json(['message' => 'added failed'], 400);
    }

    /**
     * @OA\Post(
     *       path="/materials/calcGBA",
     *       summary="calculate GBA for current user",
     *       tags={"Materials"},
     *        @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               required={"academic_year", "year", "specialization"},
     *               @OA\Property(
     *                   property="academic_year",
     *                   type="string",
     *                   example="first_year"
     *               ),
     *               @OA\Property(
     *                   property="specialization",
     *                   type="string",
     *                   example="common"
     *               ),
     *               @OA\Property(
     *                   property="year",
     *                   type="string",
     *                   example="2022"
     *               ),
     *           )
     *        ),
     *        @OA\Response(
     *          response=201, description="Successful calculated",
     *          @OA\JsonContent(
     *               @OA\Property(
     *                   property="message",
     *                   type="string",
     *                   example="gba calculated seccessfully"
     *               ),
     *          )
     *        ),
     *        @OA\Response(response=400, description="Invalid request"),
     *        security={
     *            {"bearer": {}}
     *        }
     * )
     */
    function calcGBA(Request $request)
    {
        $data = Validator::make($request->all(), [
            'academic_year' => ['required', new Enum(AcademicYear::class)],
            'specialization' => ['required', new Enum(Specialization::class)],
            'year' => 'required|string'
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $data->errors(),
            ], 400);
        }
        $data = $data->validated();

        if ($this->materialService->calcGBA($data['academic_year'], $data['year'], Auth::id(), $data['specialization']))
            return response()->json(['message' => 'gba calculated seccessfully']);
        return response()->json(['message' => 'gba calculated failed']);
    }

    /**
     * @OA\Put(
     *     path="/materials/editDegree",
     *     summary="edit some degree for material",
     *     tags={"Materials"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_name", type="string", example="Harry Potter"),
     *             @OA\Property(
     *                 property="materials",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="material", type="string"),
     *                     @OA\Property(property="degree", type="integer")
     *                 ),
     *                 example={{
     *             "material": "الفيزياء",
     *             "degree": 88,
     *              }, {
     *             "material": "التحليل 1",
     *             "degree": 75,
     *           }}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *      response=200, description="Successfully edit of degree",
     *       @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="degree for material has been changed"
     *             ),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    function editDegree(Request $request)
    {
        $data = Validator::make($request->all(), [
            'user_name' => 'required|exists:users,name',
            'materials' => 'required|array',
            'materials.*.material' => 'required|string|exists:materials,name',
            'materials.*.degree' => 'required|integer|min:0|max:100'
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $data->errors(),
            ], 400);
        }
        $data = $data->validated();

        $user_id = $this->userService->findByName($data['user_name'])->id;
        if ($this->materialService->edit($data['materials'], $user_id))
            return response()->json(['message' => 'degree for material has been changed'], 200);
        return response()->json(['message' => 'changed failed'], 400);
    }

    /**
     * @OA\Get(
     *       path="/materials/getDegree/{material}",
     *       summary="get degree for material",
     *       tags={"Materials"},
     *       @OA\Parameter(
     *            name="material",
     *            in="path",
     *            required=true,
     *            description="material name",
     *            @OA\Schema(
     *                type="string"
     *            ),
     *            example="الفيزياء"
     *        ),
     *        @OA\Response(
     *          response=200, description="Successful",
     *          @OA\JsonContent(
     *               @OA\Property(
     *                    property="degree",
     *                    type="integer",
     *                     example="90"
     *                ),
     *          )
     *        ),
     *        @OA\Response(response=400, description="Invalid request"),
     *        security={
     *            {"bearer": {}}
     *        }
     * )
     */
    function getDegreeForMaterial(string $material)
    {
        return response()->json($this->materialService->getDegreeForMaterial($material, Auth::id()));
    }

    /**
     * @OA\Get(
     *       path="/materials/getDegrees/{academic_year}/{specialization}",
     *       summary="get degrees for specialization in some academic year",
     *       tags={"Materials"},
     *       @OA\Parameter(
     *            name="academic_year",
     *            in="path",
     *            required=true,
     *            description="academic year",
     *            @OA\Schema(
     *                type="string"
     *            ),
     *            example="first_year"
     *        ),
     *        @OA\Parameter(
     *            name="specialization",
     *            in="path",
     *            required=true,
     *            description="specialization",
     *            @OA\Schema(
     *                type="string"
     *            ),
     *            example="common"
     *        ),
     *        @OA\Response(
     *          response=200, description="Successful",@OA\JsonContent()),
     *        @OA\Response(response=400, description="Invalid request"),
     *        security={
     *            {"bearer": {}}
     *        }
     * )
     */
    function getDegreesForAcademicYear(string $academic_year, string $specialization)
    {
        return response()->json($this->materialService->getDegreesForAcademicYear($academic_year, Auth::id(), $specialization));
    }

    /**
     * @OA\Get(
     *       path="/materials/getDegrees/{user_name}",
     *       summary="get degrees for user",
     *       tags={"Materials"},
     *       @OA\Parameter(
     *            name="user_name",
     *            in="path",
     *            required=true,
     *            description="user name",
     *            @OA\Schema(
     *                type="string"
     *            ),
     *            example="Harry Potter"
     *        ),
     *        @OA\Response(
     *          response=200, description="Successful",@OA\JsonContent()),
     *        @OA\Response(response=400, description="Invalid request")
     * )
     */
    function getAllDegreesForUser(string $user_name)
    {
        $user_id = $this->userService->findByName($user_name)->id;
        return response()->json($this->materialService->getAllDegreesForUser($user_id));
    }

    /**
     * @OA\Get(
     *       path="/materials/getMaterials/{academic_year}/{specialization}",
     *       summary="get materials for specialization in some academic year",
     *       tags={"Materials"},
     *       @OA\Parameter(
     *            name="academic_year",
     *            in="path",
     *            required=true,
     *            description="academic year",
     *            @OA\Schema(
     *                type="string"
     *            ),
     *            example="first_year"
     *        ),
     *        @OA\Parameter(
     *            name="specialization",
     *            in="path",
     *            required=true,
     *            description="specialization",
     *            @OA\Schema(
     *                type="string"
     *            ),
     *            example="common"
     *        ),
     *        @OA\Response(
     *          response=200, description="Successful"),
     *        @OA\Response(response=400, description="Invalid request")
     * )
     */
    function getMaterialsForYearAndSpecialization(string $academic_year, string $specialization)
    {
        return response()->json($this->materialService->getMaterialsForYearAndSpecialization($academic_year, $specialization));
    }

    /**
     * @OA\Get(
     *       path="/materials/getMaterialsForAdmin/{academic_year}/{specialization}",
     *       summary="get materials for specialization in some academic year to help admins",
     *       tags={"Materials"},
     *       @OA\Parameter(
     *            name="academic_year",
     *            in="path",
     *            required=true,
     *            description="academic year",
     *            @OA\Schema(
     *                type="string"
     *            ),
     *            example="first_year"
     *        ),
     *        @OA\Parameter(
     *            name="specialization",
     *            in="path",
     *            required=true,
     *            description="specialization",
     *            @OA\Schema(
     *                type="string"
     *            ),
     *            example="common"
     *        ),
     *        @OA\Response(
     *          response=200, description="Successful"),
     *        @OA\Response(response=400, description="Invalid request")
     * )
     */
    function getMaterialsForYearAndSpecializationForAdmin(string $academic_year, string $specialization)
    {
        return response()->json($this->materialService->getMaterialsForYearAndSpecializationForAdmin($academic_year, $specialization));
    }

    /**
     * @OA\Get(
     *       path="/materials/getGBA/{academic_year}",
     *       summary="get GBA for some academic year",
     *       tags={"Materials"},
     *       @OA\Parameter(
     *            name="academic_year",
     *            in="path",
     *            required=true,
     *            description="academic year",
     *            @OA\Schema(
     *                type="string"
     *            ),
     *            example="first_year"
     *        ),
     *        @OA\Response(
     *          response=200, description="Successful",@OA\JsonContent()),
     *        @OA\Response(response=400, description="Invalid request"),
     *        security={
     *            {"bearer": {}}
     *        }
     * )
     */
    function getGBA(string $academic_year)
    {
        $GBA = $this->materialService->getGBA(Auth::id(), $academic_year);
        return response()->json($GBA);
    }
}
