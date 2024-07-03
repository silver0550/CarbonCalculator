<?php

if (!function_exists('getEnumValues')) {
    function getEnumValues(string $enum): array
    {
        return array_map(fn($enum) => $enum->value, $enum::cases());
    }
}

if (!function_exists('convertWhPerKmToKWhPer100Km')) {
    function convertWhPerKmToKWhPer100Km(float $whPerKm): float
    {
        return $whPerKm * 0.1;
    }
}
