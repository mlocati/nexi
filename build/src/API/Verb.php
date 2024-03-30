<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\API;

enum Verb: string
{
    case GET = 'GET';
    case HEAD = 'HEAD';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case PATCH = 'PATCH';
}
