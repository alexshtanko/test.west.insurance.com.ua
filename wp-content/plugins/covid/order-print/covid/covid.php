<?php

require($_SERVER['DOCUMENT_ROOT'].'/vendor/phpoffice/phpword/bootstrap.php');

// Creating the new document...
$phpWord = new \phpoffice\phpword\PhpWord();

$templateProcessor = new TemplateProcessor('covid.docx');

$templateProcessor->setValue('name', 'John Doe');

// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($templateProcessor, 'Word2007');
$objWriter->save('helloWorld.docx');