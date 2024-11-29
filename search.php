<?php

$dsn = 'mysql:host=localhost;dbname=blog_data;charset=utf8';
$username = 'root'; // Имя пользователя MySQL
$password = ''; // Пароль пользователя MySQL

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $results = [];
    if (!empty($_GET['query']) && strlen($_GET['query']) >= 3) {
        $query = "%" . $_GET['query'] . "%";
        $stmt = $pdo->prepare("
            SELECT posts.title, comments.body AS comment
            FROM posts
            JOIN comments ON posts.id = comments.post_id
            WHERE comments.body LIKE ?
        ");
        $stmt->execute([$query]);
        $results = $stmt->fetchAll();
    }

} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск записей</title>
</head>
<body>
<h1>Поиск записей по тексту комментария</h1>
<form method="get" action="search.php">
    <input type="text" name="query" placeholder="Введите текст комментария" required>
    <button type="submit">Найти</button>
</form>

<?php if (!empty($results)): ?>
    <h2>Результаты поиска:</h2>
    <ul>
        <?php foreach ($results as $result): ?>
            <li>
                <strong><?= htmlspecialchars($result['title'], ENT_QUOTES) ?></strong><br>
                <?= htmlspecialchars($result['comment'], ENT_QUOTES) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php elseif (isset($_GET['query']) && strlen($_GET['query']) >= 3): ?>
    <p>Ничего не найдено.</p>
<?php endif; ?>
</body>
</html>
