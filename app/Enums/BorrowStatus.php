<?php

namespace App\Enums;

enum BorrowStatus: string
{
    case PENDING = 'pending';
    case BORROWED = 'borrowed';
}
