<?php

namespace Hanafalah\ModuleMedicService\Enums;

enum Label: string
{
    case OUTPATIENT         = 'RAWAT JALAN';
    case MCU                = 'MCU';
    case INPATIENT          = 'RAWAT INAP';
    case VERLOS_KAMER       = 'VK';
    case OPERATING_ROOM     = 'OR'; //OPRASI
    case EMERGENCY_UNIT     = 'UGD'; //UGD
    case ICU                = 'ICU';
    case NICU               = 'NICU';
    case LABORATORY         = 'LABORATORIUM';
    case PATHOLOGY_CLINIC   = 'PATOLOGI KLINIK';
    case PATHOLOGY_ANATOMY  = 'PATOLOGI ANATOMI';
    case RADIOLOGY          = 'RADIOLOGI';
    case ADMINISTRATION     = 'ADMINISTRASI';
    case PHARMACY           = 'FARMASI';
    case PHARMACY_UNIT      = 'INSTALASI FARMASI';
    case TREATMENT_ROOM     = 'RUANG TINDAKAN';
    case MEDICAL_RECORD     = 'MEDICAL RECORD';
    case PUSKESMAS_PEMBANTU = 'PUSKESMAS PEMBANTU';
    case POSYANDU           = 'POSYANDU';
    case SURVEILLANCE       = 'SURVEILLANCE';
    case OTHER              = 'OTHER';
}
