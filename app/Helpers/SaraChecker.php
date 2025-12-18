<?php

namespace App\Helpers;

use App\Models\KamusSara;
use Illuminate\Support\Facades\Cache;

class SaraChecker
{
    /**
     * Check if text contains SARA (Suku, Agama, Ras, Antar golongan) words
     * 
     * @param string $text
     * @return array ['has_sara' => bool, 'found_words' => array]
     */
    public static function checkSaraWords(string $text): array
    {
        // Get SARA words from cache or database
        $saraWords = Cache::remember('kamus_sara_words', 3600, function () {
            return KamusSara::pluck('kata')->map(function($kata) {
                return strtolower($kata);
            })->toArray();
        });

        if (empty($saraWords)) {
            return ['has_sara' => false, 'found_words' => []];
        }

        // Convert text to lowercase for case-insensitive comparison
        $lowercaseText = strtolower($text);
        
        // Remove extra spaces and normalize
        $normalizedText = preg_replace('/\s+/', ' ', trim($lowercaseText));
        
        $foundWords = [];
        
        foreach ($saraWords as $saraWord) {
            $saraWord = trim($saraWord);
            if (empty($saraWord)) continue;
            
            // Check if the SARA word exists in the text
            // Use word boundaries to avoid partial matches
            $pattern = '/\b' . preg_quote($saraWord, '/') . '\b/';
            
            if (preg_match($pattern, $normalizedText)) {
                $foundWords[] = $saraWord;
            }
        }

        return [
            'has_sara' => !empty($foundWords),
            'found_words' => array_unique($foundWords)
        ];
    }

    /**
     * Validate text for SARA content and return error message if found
     * 
     * @param string $text
     * @param string $fieldName
     * @return string|null Error message if SARA found, null if clean
     */
    public static function validateText(string $text, string $fieldName = 'teks'): ?string
    {
        $result = self::checkSaraWords($text);
        
        if ($result['has_sara']) {
            $foundWordsStr = implode(', ', $result['found_words']);
            return "Aksi ditolak, karena mengandung unsur SARA pada {$fieldName}";
        }
        
        return null;
    }

    /**
     * Clear SARA words cache - useful when kamus_sara is updated
     */
    public static function clearCache(): void
    {
        Cache::forget('kamus_sara_words');
    }
}