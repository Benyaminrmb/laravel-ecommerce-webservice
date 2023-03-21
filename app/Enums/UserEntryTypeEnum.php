<?php

namespace App\Enums;

enum UserEntryTypeEnum: string
{
    case EMAIL = 'email';
    case PHONE_NUMBER = 'phone_number';
}
