<?php

namespace App\Enums;

enum Specialization: string
{
    case CommonForAll = 'مشتركة لكل الاختصاصات';
    case CommonForSwAndAi = 'مشترك بين برمجيات وذكاء';
    case CommonForSwAndCs = 'مشترك بين برمجيات وشبكات';
    case SoftwareEngineeringAndInformationSystems = 'هندسة البرمجيات ونظم المعلومات';
    case ArtificialIntelligence = 'ذكاء صنعي';
    case ComputerSystemsAndNetworks = 'النظم والشبكات الحاسوبية';
}
