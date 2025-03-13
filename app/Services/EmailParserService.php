<?php

namespace App\Services;
use eXorus\PhpMimeMailParser\Parser;
use Exception;

class EmailParserService
{
    
    public function parseEmailContent(string $emailContent): string
    {
        try {

            
            $parser = new Parser();
            $parser->setText($emailContent);

            $plainText = $parser->getMessageBody('text');

            // If no plain text is found, attempt to clean the content further
            if (!$plainText) {
                $plainText = $parser->getMessageBody("html");
                $plainText = strip_tags($plainText); // Strip any remaining HTML tags
            }

            // Clean up any unwanted characters
            $plainText = preg_replace('/[^\P{C}\n]+/u', '', $plainText);

            return trim($plainText);

        } catch (Exception $e) {
            // Handle parsing errors gracefully
            logger()->error('Email parsing failed: ' . $e->getMessage());
            return '';
        }
    }
}

?>