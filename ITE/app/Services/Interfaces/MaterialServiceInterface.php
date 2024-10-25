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
     * @param array $materials
     * @param int $user_id
     * @return bool
     */
    function edit(array $materials, int $user_id): bool;

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

    /**
     * calculate gba for user in some year or academic year
     *
     * @param string $academic_year
     * @param string $year
     * @param int $user_id
     * @param string $specialization
     * @return bool
     */
    function calcGBA(string $academic_year, string $year, int $user_id, string $specialization): bool;

    /**
     * get gba of some year to some user
     *
     * @param int $user_id
     * @param string $academic_year
     */
    function getGBA(int $user_id, string $academic_year);

    /**
     * get all degrees for user
     *
     * @param int $user_id
     */
    function getAllDegreesForUser(int $user_id);
}
