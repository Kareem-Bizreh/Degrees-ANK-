<?php

namespace App\Http\Controllers;

use App\Services\Classes\CompetitorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
