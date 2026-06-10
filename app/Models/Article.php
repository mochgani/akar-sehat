<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasTranslations;

    protected $fillable = [
        'judul', 'slug', 'status', 'kategori', 'penulis',
        'konten', 'thumbnail', 'keywords', 'meta_title',
        'meta_desc', 'read_time', 'views', 'published_at', 'translations',
    ];

    protected function casts(): array
    {
        return [
            'keywords'     => 'array',
            'translations' => 'array',
            'published_at' => 'datetime',
            'views'        => 'integer',
            'read_time'    => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Article $article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->judul);
            }
            if ($article->status === 'terbit' && !$article->published_at) {
                $article->published_at = now();
            }
            if ($article->konten && !$article->read_time) {
                $wordCount = str_word_count(strip_tags($article->konten));
                $article->read_time = max(1, (int) ceil($wordCount / 200));
            }
        });
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && file_exists(public_path('asset/artikel/' . $this->thumbnail))) {
            return asset('asset/artikel/' . $this->thumbnail);
        }
        return asset('asset/artikel/placeholder.png');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'terbit')->orderByDesc('published_at');
    }
}
