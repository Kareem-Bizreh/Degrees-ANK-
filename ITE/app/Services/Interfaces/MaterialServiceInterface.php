<?php

namespace App\Services\Interfaces;

interface MaterialServiceInterface
{
    /**
     * add a degrees
     *
     * @param array $degrees
     * @return bool
     */
    function add(array $degrees): bool;

    /**
     * edit a degree for material
     *
     * @param string $material
     * @param int $degree
     * @return bool
     */
    function edit(string $material, int $degree): bool;

    /**
     * get a degree for material
     *
     * @param string $material
     * @return bool
     */
    function getDegreeForMaterial(string $material): bool;

    /**
     * get all degrees of materials for some academic year
     *
     * @param string $academic_year
     * @return bool
     */
    function getDegreesForAcademicYear(string $academic_year): bool;
}
