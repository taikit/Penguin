<?php
$comments = file_get_contents('comments.json');
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentsDecoded = json_decode($comments, true);
    $commentsDecoded[] = ['author'  => $_POST['author'],
        'text'    => $_POST['text']];
    $comments = json_encode($commentsDecoded, JSON_PRETTY_PRINT);
    file_put_contents('comments.json', $comments);
}
header('Content-Type: application/json');
header('Cache-Control: no-cache');
echo $comments;
