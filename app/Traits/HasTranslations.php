<?php

namespace App\Traits;

trait HasTranslations
{
    /**
     * Get a field value in the current (or specified) locale.
     * Falls back to the base column value if translation not found.
     */
    public function trans(string $field, string $locale = null): mixed
    {
        $locale = $locale ?? (app()->getLocale() ?: 'id');

        // Base language — return raw column
        if ($locale === 'id' || !$locale) {
            return $this->{$field} ?? '';
        }

        $translations = is_array($this->translations) ? $this->translations : [];
        return $translations[$locale][$field] ?? $this->{$field} ?? '';
    }
}
