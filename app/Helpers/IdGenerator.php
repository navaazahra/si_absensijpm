<?php

namespace App\Helpers;

class IdGenerator
{
    public static function generate(string $modelClass, string $primaryKey, string $prefix): string
    {
        $lastRecord = $modelClass::orderBy($primaryKey, 'desc')->first();

        if (!$lastRecord) {
            $number = 1;
        } else {
            $lastId = $lastRecord->$primaryKey;
            $lastNumber = (int) substr($lastId, strlen($prefix));
            $number = $lastNumber + 1;
        }

        return $prefix . str_pad($number, 7, '0', STR_PAD_LEFT);
    }
}