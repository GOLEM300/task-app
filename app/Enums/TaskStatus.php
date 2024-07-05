<?php

namespace App\Enums;

enum TaskStatus : string
{
    case DONE = 'done';
    case TESTING = 'testing';
    case IN_WORKING = 'in_working';
    case WAIT = 'wait';
}
