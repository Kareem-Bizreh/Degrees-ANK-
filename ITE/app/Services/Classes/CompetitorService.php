<?php

namespace App\Services\Classes;

use App\Services\Interfaces\CompetitorServiceInterface;
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
        $user = $this->userService->findByName($name);
        if (! $user)
            return false;
        $recrode = DB::table('competitors')
            ->where('student_id', '=', Auth::id())
            ->where('friend_id', '=', $user->id);
        if (! $recrode->get()->first())
            return false;
        $recrode->delete();
        return true;
    }

    /**
     * get my friend in descending order
     *
     * @param string $academic_year
     */
    function getCompetitors(string $academic_year)
    {
        return DB::table('competitors')
            ->join('GBAs', 'GBAs.student_id', '=', 'competitors.friend_id')
            ->join('users', 'users.id', '=', 'competitors.friend_id')
            ->where('competitors.student_id', '=', Auth::id())
            ->where('GBAs.academic_year', $academic_year)
            ->orderBy('GBAs.average', 'DESC')
            ->select('competitors.*', 'GBAs.average', 'users.name as friend_name')
            ->paginate(10);
    }
}
