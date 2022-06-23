<?php

namespace App\Models;

enum FieldTypeEnum: string
{
    case Date = "date";
    case Number = "number";
    case String = "string";
    case Boolean = "boolean";
}
