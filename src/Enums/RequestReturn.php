<?php

declare(strict_types=1);

namespace Aybarsm\Laravel\Pandle\Enums;

enum RequestReturn: string
{
    case PendingRequest = 'pendingRequest';
    case ResponseInstance = 'responseInstance';
    case RenderedResponse = 'renderedResponse';
}
