<?php

namespace App\Enums;

enum TodoStatusEnum: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
}
