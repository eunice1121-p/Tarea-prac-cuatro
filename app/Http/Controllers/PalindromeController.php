<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PalindromeController extends Controller
{
public function check(Request $request): JsonResponse
{
    $text =$request->input('text', '');
    
    if (empty(trim($text))) {
        return response()->json([
            'is_palindrome' => false,
            'message' => 'El texto introducido está vacío.'
        ], 400);
    }

    $isPalindrome = $this->isPalindrome($text);

    return response()->json([
        'original_text' => $text,
        'is_palindrome' => $isPalindrome,
        'message' => $isPalindrome ? 'Es un palíndromo.' : 'No es un palíndromo.'
    ]);
}

private function isPalindrome(string $string): bool
{
    $cleanString = mb_strtolower($string, 'UTF-8');
    $cleanString = preg_replace('/[áàäâ]/u', 'a', $cleanString);
    $cleanString = preg_replace('/[éèëê]/u', 'e', $cleanString);
    $cleanString = preg_replace('/[íìïî]/u', 'i', $cleanString);
    $cleanString = preg_replace('/[óòöô]/u', 'o', $cleanString);
    $cleanString = preg_replace('/[úùüû]/u', 'u', $cleanString);
    $cleanString = preg_replace('/[^a-z0-9]/u', '',$cleanString);

    $reversedString = implode('', array_reverse(mb_str_split($cleanString)));

    return $cleanString ===$reversedString;
}
}
