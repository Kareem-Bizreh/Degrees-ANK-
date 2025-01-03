<?php

namespace App\Services\Classes;

use App\Services\Interfaces\CompetitorServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompetitorService implements CompetitorServiceInterface
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * add competitor for current user
     *
     * @param string $name
     * @return bool
     */
    function addCompetitor(string $name): bool
    {
        DB::beginTransaction();
        try {
            $user = $this->userService->findByName($name);
            if (! $user)
                return false;
            $recrode = DB::table('competitors')
                ->where('student_id', '=', Auth::id())
                ->where('friend_id', '=', $user->id)
                ->get()->first();
            if ($recrode)
                return false;
            DB::table('competitors')->insert([
                'student_id' => Auth::id(),
                'friend_id' => $user->id
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * delete some competitor for current user
     *
     * @param string $name
     * @return bool
     */
    function deleteCompetitor(string $name)
    {
        DB::beginTransaction();
        try {
            $user = $this->userService->findByName($name);
            if (! $user)
                return false;
            $recrode = DB::table('competitors')
                ->where('student_id', '=', Auth::id())
                ->where('friend_id', '=', $user->id);
            if (! $recrode->get()->first())
                return false;
            $recrode->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * get my friend in descending order
     *
     * @param string $academic_year
     * @param string $specialization
     */
    function getCompetitors(string $academic_year, string $specialization)
    {
        return DB::table('competitors')
            ->join('GBAs', 'GBAs.student_id', '=', 'competitors.friend_id')
            ->join('users', 'users.id', '=', 'competitors.friend_id')
            ->where('competitors.student_id', '=', Auth::id())
            ->where('GBAs.academic_year', $academic_year)
            ->where('GBAs.specialization', $specialization)
            ->orderBy('GBAs.average', 'DESC')
            ->select(
                'competitors.*',
                'GBAs.average',
                'users.name as friend_name',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name")
            )
            ->paginate(10);
    }

    /**
     * get all competitors of user
     */
    function getAllCompetitors()
    {
        $competitors = DB::table('competitors')
            ->join('GBAs', 'GBAs.student_id', '=', 'competitors.friend_id')
            ->join('users', 'users.id', '=', 'competitors.friend_id')
            ->where('competitors.student_id', '=', Auth::id())
            ->select(
                'users.name as friend_name',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"),
                'GBAs.academic_year',
                'GBAs.average'
            )
            ->get();
        $data = [];
        foreach ($competitors as $competitor) {
            if (!isset($data[$competitor->friend_name])) {
                $data[$competitor->friend_name] = [
                    'full_name' => $competitor->full_name,
                    'GBAs' => [
                        'first_year' => null,
                        'second_year' => null,
                        'third_year' => null,
                        'fourth_year' => null,
                        'fifth_year' => null
                    ]
                ];
            }
            $data[$competitor->friend_name]['GBAs'][$competitor->academic_year] = $competitor->average;
        }

        $data = collect($data);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $offset = ($currentPage - 1) * 10;
        $currentPageItems = $data->slice($offset, 10);
        $total = $data->count();
        $paginatedData = new LengthAwarePaginator($currentPageItems, $total, 10, $currentPage);

        return $paginatedData;
    }


    /**
     * get all of my class in academic year for some specialization in descending order
     *
     * @param string $academic_year
     * @param string $specialization
     * @param int $user_id
     */
    function getOrderOfMyClass(string $academic_year, string $specialization, int $user_id)
    {
        $recorde = DB::table('GBAs')
            ->where('student_id', '=', $user_id)
            ->where('academic_year', '=', $academic_year)
            ->where('specialization', '=', $specialization)
            ->get()->first();
        if (!$recorde) {
            return new LengthAwarePaginator([], 0, 10, 1);
        }
        return DB::table('GBAs')
            ->join('users', 'users.id', '=', 'GBAs.student_id')
            ->where('year', '=', $recorde->year)
            ->where('academic_year', '=', $academic_year)
            ->where('specialization', '=', $specialization)
            ->orderBy('GBAs.average', 'DESC')
            ->select(
                'GBAs.average',
                'users.name as name',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name")
            )
            ->paginate(10);
    }
}