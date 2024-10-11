<?php

namespace Database\Seeders;

use App\Enums\AcademicYear;
use App\Enums\Specialization;
use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::create([
            'name' => 'الفيزياء',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'التحليل 1',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'الجبر العام',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'مبادئ عمل الحواسيب',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'البرمجة 1',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1,
        ]);

        Material::create([
            'name' => 'انكليزي 1',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1,
        ]);

        Material::create([
            'name' => 'التحليل 2',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2,
        ]);

        Material::create([
            'name' => 'الجبر الخطي',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2,
        ]);

        Material::create([
            'name' => 'البرمجة 2',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2,
        ]);

        Material::create([
            'name' => 'الثقافة القومية الاشتراكية',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2,
        ]);

        Material::create([
            'name' => 'الدارات الكهربائية و الالكترونية',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2,
        ]);

        Material::create([
            'name' => 'انكليزي 2',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2,
        ]);

        Material::create([
            'name' => 'اللغة العربية',
            'academic_year' => AcademicYear::FirstYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2,
        ]);


        Material::create([
            'name' => 'التحليل 3',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1,
        ]);

        Material::create([
            'name' => 'الخوارزميات و بنى المعطيات 1',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1,
        ]);

        Material::create([
            'name' => 'انكليزي 3',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1,
        ]);

        Material::create([
            'name' => 'الدارات المنطقية',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1,
        ]);

        Material::create([
            'name' => 'الاحتمالات و الاحصاء',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'البرمجة 3',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'الخوارزميات و بنى المعطيات 2',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'مهارات التواصل',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'بنيان الحواسيب 1',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'الاتصالات الرقمية',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'التحليل العددي',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'انكليزي 4',
            'academic_year' => AcademicYear::SecondYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'بحوث العمليات',
            'academic_year' => AcademicYear::ThirdYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'لغات البرمجة',
            'academic_year' => AcademicYear::ThirdYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'بنيان الحواسيب 2',
            'academic_year' => AcademicYear::ThirdYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'أساسيات الشبكات',
            'academic_year' => AcademicYear::ThirdYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'الحسابات العلمية',
            'academic_year' => AcademicYear::ThirdYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'اللغات الصورية',
            'academic_year' => AcademicYear::ThirdYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'قواعد المعطيات 1',
            'academic_year' => AcademicYear::ThirdYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'البيانيات',
            'academic_year' => AcademicYear::ThirdYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'مبادئ الذكاء الصنعي',
            'academic_year' => AcademicYear::ThirdYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'مشروع 1',
            'academic_year' => AcademicYear::ThirdYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'نظم تشغيل 1',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'هندسة البرمجيات 1',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'الاقتصاد و الإدارة في مؤسسة',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'خوارزميات البحث الذكية',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'المترجمات',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::CommonForSwAndAi->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'قواعد المعطيات 2',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::SoftwareEngineeringAndInformationSystems->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'البرمجة التفرعية',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'نظم الوسائط المتعددة والفائقة',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'هندسة البرمجيات 2',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::SoftwareEngineeringAndInformationSystems->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'مشروع المترجمات',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::SoftwareEngineeringAndInformationSystems->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'مشروع 2',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'التسويق',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'برمجة التطبيقات الشبكية',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::ComputerSystemsAndNetworks->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'نظم التشغيل 2',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::ComputerSystemsAndNetworks->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'برتوكولات الاتصالات الحاسوبية',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::ComputerSystemsAndNetworks->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'الشبكات العصبونية',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::ArtificialIntelligence->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'نظم قواعد المعرفة',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::ArtificialIntelligence->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'الحقائق الافتراضية',
            'academic_year' => AcademicYear::FourthYear->value,
            'specialization' => Specialization::ArtificialIntelligence->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'أمن نظم معلومات',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'إدارة المشاريع',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'هندسة البرمجيات 3',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::SoftwareEngineeringAndInformationSystems->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'قواعد المعطيات المتقدمة',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::SoftwareEngineeringAndInformationSystems->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'تطبيقات الانترنت',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::SoftwareEngineeringAndInformationSystems->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'مشروع تخرج',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::CommonForAll->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'النظم و التطبيقات الموزعة',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::CommonForSwAndCs->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'نظم البحث عن المعلومات',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::SoftwareEngineeringAndInformationSystems->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'هندسة نظم المعلومات',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::SoftwareEngineeringAndInformationSystems->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'نظم الزمن الحقيقي',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::ComputerSystemsAndNetworks->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'إدارة الشبكات الحاسوبية',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::ComputerSystemsAndNetworks->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'تصميم الشبكات الحاسوبية',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::ComputerSystemsAndNetworks->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'نمذجة و محاكاة النظم الشبكية',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::ComputerSystemsAndNetworks->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'أمن الشبكات الحاسوبية',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::ComputerSystemsAndNetworks->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'الروبوتية',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::ArtificialIntelligence->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'معالجة اللغات الطبيعية',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::ArtificialIntelligence->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'الرؤية الحاسوبية',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::ArtificialIntelligence->value,
            'semesterNumber' => 1
        ]);

        Material::create([
            'name' => 'المنطق الترجيحي و الخوارزميات الورائية',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::ArtificialIntelligence->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'استكشاف المعرفة',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::ArtificialIntelligence->value,
            'semesterNumber' => 2
        ]);

        Material::create([
            'name' => 'التعلم التلقائي',
            'academic_year' => AcademicYear::FifthYear->value,
            'specialization' => Specialization::ArtificialIntelligence->value,
            'semesterNumber' => 2
        ]);
    }
}