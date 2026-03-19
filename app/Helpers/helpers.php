<?php

/**
 * Convert number to words (Indian numbering system with crores, lakhs)
 */
if (!function_exists('numberToWordsInIndianFormat')) {
    function numberToWordsInIndianFormat($number)
    {
        if ($number == 0) {
            return 'zero';
        }
        
        $words = [];
        
        // Crores (1,00,00,000)
        if ($number >= 10000000) {
            $crores = floor($number / 10000000);
            $words[] = convertToWordsBasic($crores) . ' crore';
            $number %= 10000000;
        }
        
        // Lakhs (1,00,000)
        if ($number >= 100000) {
            $lakhs = floor($number / 100000);
            $words[] = convertToWordsBasic($lakhs) . ' lakh';
            $number %= 100000;
        }
        
        // Thousands
        if ($number >= 1000) {
            $thousands = floor($number / 1000);
            $words[] = convertToWordsBasic($thousands) . ' thousand';
            $number %= 1000;
        }
        
        // Hundreds
        if ($number >= 100) {
            $hundreds = floor($number / 100);
            $words[] = convertToWordsBasic($hundreds) . ' hundred';
            $number %= 100;
        }
        
        // Remaining
        if ($number > 0) {
            $words[] = convertToWordsBasic($number);
        }
        
        return implode(' ', $words);
    }
}

/**
 * Basic number to words converter (up to 999)
 */
if (!function_exists('convertToWordsBasic')) {
    function convertToWordsBasic($num)
    {
        if ($num == 0) {
            return '';
        }
        
        $ones = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 
                'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 
                'seventeen', 'eighteen', 'nineteen'];
        $tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
        
        if ($num < 20) {
            return $ones[$num];
        } elseif ($num < 100) {
            return $tens[floor($num / 10)] . ($num % 10 != 0 ? '-' . $ones[$num % 10] : '');
        }
        
        return '';
    }
}

/**
 * Legacy function name for backward compatibility
 */
if (!function_exists('crore')) {
    function crore($number)
    {
        return numberToWordsInIndianFormat($number);
    }
}
