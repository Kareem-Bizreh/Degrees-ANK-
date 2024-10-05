<?php

namespace App\Services\Interfaces;

interface CompetitorServiceInterface
{
    /**
     * add competitor for current user
     *
     * @param string $name
     * @return bool
     */
    function addCompetitor(string $name): bool;

    /**
     * delete some competitor for current user
     *
     * @param string $name
     * @return bool
     */
    function deleteCompetitor(string $name);
    /**
     * get my friend in descending order
     *
     * @param string $academic_year
     */
    function getCompetitors(string $academic_year);
}
