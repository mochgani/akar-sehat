<?php

namespace App\Support;

/**
 * Helper untuk merender konten WYSIWYG pada wrapper inline (mis. <p>/<h3>) tanpa
 * masalah elemen blok bersarang, sambil tetap mempertahankan rata teks (text-align).
 */
class RichText
{
    /** True jika konten mengandung elemen blok (list, heading, div, dll) atau lebih dari satu paragraf. */
    public static function isBlock(?string $html): bool
    {
        $h = trim((string) $html);
        if ($h === '') return false;
        return (bool) preg_match('/<(ul|ol|h[1-6]|div|blockquote|table)\b/i', $h)
            || substr_count(strtolower($h), '<p') > 1;
    }

    /** Ambil rata teks dari satu paragraf tunggal yang punya style text-align. */
    public static function align(?string $html): ?string
    {
        $h = trim((string) $html);
        if ($h === '' || substr_count(strtolower($h), '<p') !== 1) return null;
        if (!preg_match('/^<p\b/i', $h) || !preg_match('/<\/p>$/i', $h)) return null;
        if (preg_match('/text-align:\s*(left|right|center|justify)/i', $h, $m)) {
            return strtolower($m[1]);
        }
        return null;
    }

    /** Lepas bungkus <p>…</p> tunggal (beserta atributnya) untuk dirender di wrapper inline. */
    public static function inline(?string $html): string
    {
        $h = trim((string) $html);
        if (substr_count(strtolower($h), '<p') === 1 && preg_match('/^<p\b[^>]*>(.*)<\/p>$/is', $h, $m)) {
            return $m[1];
        }
        return $h;
    }
}
