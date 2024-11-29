<?php

$dsn = 'mysql:host=localhost;dbname=blog_data;charset=utf8';
$username = 'root'; // Имя пользователя MySQL
$password = ''; // Пароль пользователя MySQL

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Скачивание записи
    $posts = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'), true);
    $comments = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'), true);

    // Загрузка записей
    $stmtPost = $pdo->prepare("INSERT INTO posts (id, user_id, title, body) VALUES (?, ?, ?, ?)");
    foreach ($posts as $post) {
        $stmtPost->execute([$post['id'], $post['userId'], $post['title'], $post['body']]);
    }

    // Загрузка комментариев
    $stmtComment = $pdo->prepare("INSERT INTO comments (id, post_id, name, email, body) VALUES (?, ?, ?, ?, ?)");
    foreach ($comments as $comment) {
        $stmtComment->execute([$comment['id'], $comment['postId'], $comment['name'], $comment['email'], $comment['body']]);
    }

    echo "Загружено " . count($posts) . " записей и " . count($comments) . " комментариев\n";

} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
