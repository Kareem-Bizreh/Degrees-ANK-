<?php

namespace App\Enums;

enum Specialization: string
{
    case CommonForAll = 'common';
    case CommonForSwAndAi = 'common_for_sw_and_ai';
    case CommonForSwAndCs = 'common_for_sw_and_cs';
    case SoftwareEngineeringAndInformationSystems = 'SE';
    case ArtificialIntelligence = 'AI';
    case ComputerSystemsAndNetworks = 'IT';
}
