<?php

namespace App\Services\Classes;

use App\Enums\Specialization;
use App\Models\Material;
use App\Services\Interfaces\MaterialServiceInterface;
use Illuminate\Support\Facades\DB;

class MaterialService implements MaterialServiceInterface
{
    /**
     * find material by name
     *
     * @param string $name
     * @return Material
     */
    function FindMaterialByName(string $name)
    {
        return Material::where('name', $name)->get()->first();
    }

    /**
     * add a degrees
     *
     * @param array $degrees
     * @param int $user_id
     * @return bool
     */
    function add(array $degrees, int $user_id): bool
    {
        DB::beginTransaction();
        try {
            foreach ($degrees as $data) {
                $material = $data['material'];
                $degree = $data['degree'];
                DB::table('material_student')->insert([
                    'student_id' => $user_id,
                    'material_id' => $this->FindMaterialByName($material)->id,
                    'degree' => $degree
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * edit a degree for material
     *
     * @param string $material
     * @param int $degree
     * @param string $user
     * @return bool
     */
    function edit(string $material, int $degree, int $user_id): bool
    {
        DB::beginTransaction();
        try {
            $material_id = $this->FindMaterialByName($material)->id;
            DB::table('material_student')
                ->where('material_id', '=', $material_id)
                ->where('student_id', '=', $user_id)
                ->update([
                    'degree' => $degree
                ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * get a degree for material
     *
     * @param string $material
     * @param int $user_id
     */
    function getDegreeForMaterial(string $material, int $user_id)
    {
        $material_id = $this->FindMaterialByName($material)->id;
        return DB::table('material_student')
            ->where('material_id', '=', $material_id)
            ->where('student_id', '=', $user_id)
            ->get(['degree'])->first();
    }

    /**
     * get all degrees of materials for some academic year
     *
     * @param string $academic_year
     * @param int $user_id
     * @param string $specialization
     */
    function getDegreesForAcademicYear(string $academic_year, int $user_id, string $specialization)
    {
        $materials = $this->getMaterialsForYearAndSpecialization($academic_year, $specialization);
        $data = [];
        foreach ($materials as $material) {
            $degree = $this->getDegreeForMaterial($material->name, $user_id);
            $data[] = [
                'material_name' => $material->name,
                'degree' => ($degree ? $degree->degree : null),
                'semesterNumber' => $material->semesterNumber
            ];
        }
        return $data;
    }

    /**
     * get materials for some academic year and in a specific specialization
     *
     * @param string $academic_year
     * @param string $specialization
     */
    function getMaterialsForYearAndSpecialization(string $academic_year, string $specialization)
    {
        $materials = Material::where('academic_year', $academic_year)->get();
        if ($specialization == Specialization::SoftwareEngineeringAndInformationSystems->value) {
            $materials = $materials->filter(function ($material) {
                return
                    $material->specialization == Specialization::SoftwareEngineeringAndInformationSystems->value
                    || $material->specialization == Specialization::CommonForSwAndAi->value
                    || $material->specialization == Specialization::CommonForSwAndCs->value
                    || $material->specialization == Specialization::CommonForAll->value;
            });
        }
        if ($specialization == Specialization::ArtificialIntelligence->value) {
            $materials = $materials->filter(function ($material) {
                return
                    $material->specialization == Specialization::ArtificialIntelligence->value
                    || $material->specialization == Specialization::CommonForSwAndAi->value
                    || $material->specialization == Specialization::CommonForAll->value;
            });
        }
        if ($specialization == Specialization::ComputerSystemsAndNetworks->value) {
            $materials = $materials->filter(function ($material) {
                return
                    $material->specialization == Specialization::ComputerSystemsAndNetworks->value
                    || $material->specialization == Specialization::CommonForSwAndCs->value
                    || $material->specialization == Specialization::CommonForAll->value;
            });
        }
        return $materials->values();
    }

    /**
     * calculate gba for user in some year or academic year
     *
     * @param string $academic_year
     * @param string $year
     * @param int $user_id
     * @param string $specialization
     * @return bool
     */
    function calcGBA(string $academic_year, string $year, int $user_id, string $specialization): bool
    {
        DB::beginTransaction();
        try {
            $degrees = $this->getDegreesForAcademicYear($academic_year, $user_id, $specialization);
            $degrees = collect($degrees);
            $recorde = DB::table('GBAs')
                ->where('student_id', '=', $user_id)
                ->where('academic_year', '=', $academic_year)
                ->where('specialization', '=', $specialization)
                ->get()->first();
            if ($recorde)
                return false;
            DB::table('GBAs')->insert([
                'student_id' => $user_id,
                'academic_year' => $academic_year,
                'specialization' => $specialization,
                'year' => $year,
                'average' => $degrees->sum('degree') / $degrees->count()
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    /**
     * get gba of some year to some user
     *
     * @param int $user_id
     * @param string $academic_year
     */
    function getGBA(int $user_id, string $academic_year)
    {
        return DB::table('GBAs')
            ->where('student_id', '=', $user_id)
            ->where('academic_year', '=', $academic_year)
            ->get()->first();
    }
}