<?php

namespace Hanafalah\ModuleMedicService\Enums;

enum Label: string
{
    case OUTPATIENT      = 'RAWAT JALAN';
    case MCU             = 'MCU';
    case INPATIENT       = 'RAWAT INAP';
    case VERLOS_KAMER    = 'VK';
    case OPERATING_ROOM  = 'OR'; //OPRASI
    case EMERGENCY_UNIT  = 'UGD'; //UGD
    case ICU             = 'ICU';
    case NICU            = 'NICU';
    case LABORATORY      = 'LABORATORIUM';
    case RADIOLOGY       = 'RADIOLOGI';
    case ADMINISTRATION  = 'ADMINISTRASI';
    case PHARMACY        = 'FARMASI';
    case PHARMACY_UNIT   = 'INSTALASI FARMASI';
    case MEDICAL_RECORD  = 'MEDICAL RECORD';
    case OTHER           = 'OTHER';
}
