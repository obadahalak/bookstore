<?php

namespace App\enum;

enum NotificationMessage: string
{
    case ACCEPT = 'your Book has been published by admin';

    case REJECT = 'your Book has been regected by admin';
}
