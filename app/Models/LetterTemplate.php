<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LetterTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'template_content',
        'placeholders',
        'is_active',
    ];

    protected $casts = [
        'placeholders' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get all letters generated from this template
     */
    public function letters()
    {
        return $this->hasMany(Letter::class);
    }

    /**
     * Replace numbered placeholders in template with actual values
     */
    public function replacePlaceholders(array $values = []): string
    {
        $content = $this->template_content;
        
        // Sort placeholders in descending order to avoid replacement conflicts
        $placeholders = $this->getPlaceholdersAttribute() ?? [];
        rsort($placeholders);
        
        foreach ($placeholders as $placeholder) {
            $value = $values[$placeholder] ?? '{' . $placeholder . '}';
            $content = str_replace('{' . $placeholder . '}', $value, $content);
        }
        
        return $content;
    }

    /**
     * Generate letter content using provided values
     */
    public function generateContent(array $values = []): string
    {
        return $this->replacePlaceholders($values);
    }

    /**
     * Extract numbered placeholders from template content
     */
    public function getPlaceholdersAttribute(): array
    {
        preg_match_all('/\{(\d+)\}/', $this->template_content, $matches);
        return array_map('intval', array_unique($matches[1]));
    }

    /**
     * Get placeholder count
     */
    public function getPlaceholderCountAttribute(): int
    {
        return count($this->getPlaceholdersAttribute());
    }
}
