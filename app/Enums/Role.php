<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case VERIFIED_USER = 'verified_user';
    case UNVERIFIED_USER = 'unverified_user';
}
