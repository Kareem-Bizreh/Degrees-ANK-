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
     * @param string $specialization
     */
    function getCompetitors(string $academic_year, string $specialization);

    /**
     * get all competitors of user
     */
    function getAllCompetitors();

    /**
     * get all of my class in academic year for some specialization in descending order
     *
     * @param string $academic_year
     * @param string $specialization
     * @param int $user_id
     */
    function getOrderOfMyClass(string $academic_year, string $specialization, int $user_id);
}