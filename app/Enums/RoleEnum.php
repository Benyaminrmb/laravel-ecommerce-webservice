<?php

namespace App\Enums;

enum RoleEnum: string
{
    case UNVERIFIED_USER = 'unverified_user';
    case VERIFIED_USER = 'verified_user';
    case ADMIN = 'admin';
}
