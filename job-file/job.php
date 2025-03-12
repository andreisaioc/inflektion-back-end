<?php

require 'vendor/autoload.php';

use PhpMimeMailParser\Parser;

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'emails');
define('DB_USER', '');
define('DB_PASS', '');

//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, 'developer', 'pass123');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Fetch unprocessed emails
$sql = "SELECT id, email FROM successful_emails WHERE raw_text = '' order by rand() LIMIT 100";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($emails as $email) {


    $plainText = extractPlainText($email['email']);
    $cleanedText = removeCSS($plainText);    

    //Update database
    $updateSQL = "UPDATE successful_emails SET raw_text = :plain_text WHERE id = :id";
    $updateStmt = $pdo->prepare($updateSQL);
    $updateStmt->execute([
        ':plain_text' => $cleanedText,
        ':id' => $email['id'],
    ]);

   echo "Processed email ID: " . $email['id'] . "\n<br/><br/>";
   
}
 

function extractPlainText($rawContent)
{
    $parser = new Parser();
    $parser->setText($rawContent);

    // Extract the plain text body
    $plainText = $parser->getMessageBody('text');

    // If no plain text is found, attempt to clean the content further
    if (!$plainText) {
        $plainText = $parser->getMessageBody("html");
        $plainText = strip_tags($plainText); // Strip any remaining HTML tags
    }

    // Normalize line breaks and remove excessive whitespace
    $plainText = preg_replace("/\r\n|\r|\n/", "\n", $plainText);
    $plainText = trim(preg_replace('/[\t ]+/', ' ', $plainText));

    return $plainText;
}




function removeCSS($content) {
    // Remove CSS comments like /* ... */
    $content = preg_replace('/\/\*[\s\S]*?\*\//', '', $content);

    // Remove <style> tags and their content
    $content = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $content);

    // Remove @import CSS statements
    $content = preg_replace('/@import[^;]+;/is', '', $content);

    // Remove media queries
    $content = preg_replace('/@media[^{]+\{([\s\S]+?)\}/is', '', $content);

    // Remove inline CSS rules
    $content = preg_replace('/([a-zA-Z0-9\-\_]+)\s*\{\s*[^\}]*\}/is', '', $content);

    // Clean excess newlines and spaces
    $content = preg_replace('/\n{2,}/', "\n", $content); // Limit to 1 new line
    $content = preg_replace('/^\s*$/m', '', $content);   // Remove empty lines

    // Trim whitespace from the start and end
    return trim($content);
}


?>