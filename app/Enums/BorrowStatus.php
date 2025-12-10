<?php
namespace App\Enums;

enum BorrowStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case BORROWED = 'borrowed';
    case REJECTED = 'rejected';
    case FINISHED = 'finished';
}
