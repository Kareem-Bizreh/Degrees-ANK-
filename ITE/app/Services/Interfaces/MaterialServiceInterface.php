<?php

namespace App\Services\Interfaces;

interface MaterialServiceInterface
{
    /**
     * find material by name
     *
     * @param string $name
     * @return Material
     */
    function FindMaterialByName(string $name);

    /**
     * add a degrees
     *
     * @param array $degrees
     * @param int $user_id
     * @return bool
     */
    function add(array $degrees, int $user_id): bool;

    /**
     * edit a degree for material
     *
     * @param string $material
     * @param int $degree
     * @param int $user_id
     * @return bool
     */
    function edit(string $material, int $degree, int $user_id): bool;

    /**
     * get a degree for material
     *
     * @param string $material
     * @param int $user_id
     */
    function getDegreeForMaterial(string $material, int $user_id);

    /**
     * get all degrees of materials for some academic year
     *
     * @param string $academic_year
     * @param int $user_id
     * @param string $specialization
     */
    function getDegreesForAcademicYear(string $academic_year, int $user_id, string $specialization);

    /**
     * get materials for some academic year and in a specific specialization
     *
     * @param string $academic_year
     * @param string $specialization
     */
    function getMaterialsForYearAndSpecialization(string $academic_year, string $specialization);
}
