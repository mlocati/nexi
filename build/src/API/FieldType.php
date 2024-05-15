<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Build\API;

enum FieldType: string
{
    case Integer = 'int';
    case Str = 'string';
    case Obj = 'object';
    case Boolean = 'bool';
}
