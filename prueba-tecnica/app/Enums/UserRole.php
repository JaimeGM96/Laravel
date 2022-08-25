<?php

namespace App\Enums;

enum UserRole : int
{
    case PARTICIPANT = 0;
    case MANAGER = 1;
}
