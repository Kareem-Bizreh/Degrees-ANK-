<?php

namespace App\Http\Controllers;

use App\Enums\AcademicYear;
use App\Services\Classes\CompetitorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class CompetitorController extends Controller
{
    protected $competitorService;

    public function __construct(CompetitorService $competitorService)
    {
        $this->competitorService = $competitorService;
    }

    /**
     * @OA\Post(
     *       path="/competitors/addCompetitor",
     *       summary="add new competitor",
     *       tags={"Competitors"},
     *        @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               required={"friend_name"},
     *               @OA\Property(
     *                   property="friend_name",
     *                   type="string",
     *                   example="Ron Weasly"
     *               ),
     *           )
     *        ),
     *        @OA\Response(
     *          response=201, description="Successful added",
     *          @OA\JsonContent(
     *               @OA\Property(
     *                   property="message",
     *                   type="string",
     *                   example="competitor added seccessfully"
     *               ),
     *          )
     *        ),
     *        @OA\Response(response=400, description="Invalid request"),
     *        security={
     *            {"bearer": {}}
     *        }
     * )
     */
    public function addCompetitor(Request $request)
    {
        $validateDate = Validator::make($request->all(), [
            'friend_name' => 'required|string|max:20|exists:users,name'
        ]);

        if ($validateDate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validateDate->errors(),
            ], 400);
        }
        $validateDate = $validateDate->validated();
        if ($this->competitorService->addCompetitor($validateDate['friend_name']))
            return response()->json(['message' => 'competitor added succesfully'], 200);
        return response()->json(['message' => 'competitor added faild'], 400);
    }

    /**
     * @OA\Get(
     *       path="/competitors/getCompetitors/{academic_year}",
     *       summary="get competitors order by GBAs in some year",
     *       tags={"Competitors"},
     *        @OA\Parameter(
     *            name="academic_year",
     *            in="path",
     *            required=true,
     *            description="academic year",
     *            @OA\Schema(
     *                type="string"
     *            )
     *        ),
     *        @OA\Parameter(
     *            name="page",
     *            in="query",
     *            required=true,
     *            description="page number",
     *            @OA\Schema(
     *                type="integer"
     *            )
     *        ),
     *        @OA\Response(
     *          response=201, description="Successful get competitors",
     *          @OA\JsonContent(
     *               @OA\Property(
     *                   property="competitors",
     *                   type="string",
     *                   example="[]"
     *               ),
     *          )
     *        ),
     *        @OA\Response(response=400, description="Invalid request"),
     *        security={
     *            {"bearer": {}}
     *        }
     * )
     */
    function getCompetitors(string $academic_year)
    {
        $competitors = $this->competitorService->getCompetitors($academic_year);

        return response()->json([
            'current_page' => $competitors->currentPage(),
            'last_page' => $competitors->lastPage(),
            'per_page' => $competitors->perPage(),
            'total' => $competitors->total(),
            'competitors' => $competitors->items() // تغيير الاسم هنا
        ]);
    }

    /**
     * @OA\Delete(
     *       path="/competitors/deleteCompetitor",
     *       summary="delete existing competitor",
     *       tags={"Competitors"},
     *        @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               required={"friend_name"},
     *               @OA\Property(
     *                   property="friend_name",
     *                   type="string",
     *                   example="Ron Weasly"
     *               ),
     *           )
     *        ),
     *        @OA\Response(
     *          response=201, description="Successful deleted",
     *          @OA\JsonContent(
     *               @OA\Property(
     *                   property="message",
     *                   type="string",
     *                   example="competitor deleted seccessfully"
     *               ),
     *          )
     *        ),
     *        @OA\Response(response=400, description="Invalid request"),
     *        security={
     *            {"bearer": {}}
     *        }
     * )
     */
    public function deleteCompetitor(Request $request)
    {
        $validateDate = Validator::make($request->all(), [
            'friend_name' => 'required|string|max:20|exists:users,name'
        ]);

        if ($validateDate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validateDate->errors(),
            ], 400);
        }
        $validateDate = $validateDate->validated();
        if ($this->competitorService->deleteCompetitor($validateDate['friend_name']))
            return response()->json(['message' => 'competitor deleted succesfully'], 200);
        return response()->json(['message' => 'competitor deleted faild'], 400);
    }
}
