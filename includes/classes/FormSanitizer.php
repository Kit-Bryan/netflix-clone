<?php

class FormSanitizer
{
    public static function sanitizeFormString($inputText)
    {
        // Remove all html tags
        $inputText = strip_tags($inputText);
        // Remove all whitespace
        $inputText = str_replace(" ", "", $inputText);
        // Lowercase entire string
        $inputText = strtolower($inputText);
        // Uppercase first letter
        $inputText = ucfirst($inputText);

        return $inputText;
    }

    public static function sanitizeFormUsername($inputText)
    {
        // Remove all html tags
        $inputText = strip_tags($inputText);
        // Remove all whitespace
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

    public static function sanitizeFormPassword($inputText)
    {
        // Remove all html tags
        $inputText = strip_tags($inputText);
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText)
    {
        // Remove all html tags
        $inputText = strip_tags($inputText);
        // Remove all whitespace
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }
}
