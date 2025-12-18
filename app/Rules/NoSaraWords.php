<?php

namespace App\Rules;

use App\Helpers\SaraChecker;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoSaraWords implements ValidationRule
{
    protected string $fieldName;
    
    public function __construct(string $fieldName = 'teks')
    {
        $this->fieldName = $fieldName;
    }
    
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            return;
        }
        
        $errorMessage = SaraChecker::validateText($value, $this->fieldName);
        
        if ($errorMessage) {
            $fail($errorMessage);
        }
    }
}