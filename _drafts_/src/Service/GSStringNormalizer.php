<?php

namespace GS\GenericParts\Service;

class StringNormalizer
{
    public static function getFullLocale(string $locale): string
    {
        $fullLocale             = $locale;

        if (!\str_contains($locale, '_')) {
            $fullLocale = \strtolower($locale) . '_' . \strtoupper($locale);
        }

        return $fullLocale;
    }
}
