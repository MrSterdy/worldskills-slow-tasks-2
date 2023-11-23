<?php

namespace WSCrop\Core;

use WSCrop\Core\Database\Database;

class Loader
{
    public static function load(): void
    {
        Database::getInstance()->connect();
    }
}