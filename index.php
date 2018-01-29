<?php

require "src/Config.php";
require "src/Api.php";
require "src/Query.php";

require "vendor/autoload.php";

$host = 'http://94.254.0.188';

$port = 4000;

try {
    $config = new \Aidenko\ChubikPhpdevtest\Config($host, $port);
} catch (Exception $e) {
    print 'Incorrect config data: ['.$e->getMessage().']';
    die;
}

$api = new \Aidenko\ChubikPhpdevtest\Api($config);

$books = $api->books()->get();
$authors = $api->authors()->get();
$author_books = $api->authorBooks(2)->get();
$limited_books = $api->books()->limit(1, 3)->get();
$limited_authors = $api->authors()->limit(1)->get();
$wrong_author = $api->authorBooks(22)->get();

ob_start(); ?>

    <!DOCTYPE html>
    <html>
    <head></head>
    <body>

    <h2>
        Books
    </h2>

    <h4>Status <?=$books->status()?></h4>
    <h4>Message <?=$books->message?></h4>
    <h4>Rows <?=$books->rows?></h4>
    <h4>Results <?=$books->results?></h4>

    <pre>
        <?php print_r(json_encode($books->books, JSON_PRETTY_PRINT))?>
    </pre>

    <h2>
        Limited Books
    </h2>

    <h4>Status <?=$limited_books->status()?></h4>
    <h4>Message <?=$limited_books->message?></h4>
    <h4>Rows <?=$limited_books->rows?></h4>
    <h4>Results <?=$limited_books->results?></h4>

    <pre>
        <?php print_r(json_encode($limited_books->books, JSON_PRETTY_PRINT))?>
    </pre>

    <h2>
        Wrong Author
    </h2>

    <h4>Status <?=$wrong_author->status()?></h4>
    <h4>Message <?=$wrong_author->message?></h4>
    <h4>Rows <?=$wrong_author->rows?></h4>
    <h4>Results <?=$wrong_author->results?></h4>

    <pre>
        <?php print_r(json_encode($wrong_author->books, JSON_PRETTY_PRINT))?>
    </pre>

    </body>
    </html>


<?php print ob_get_clean();



