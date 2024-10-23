<!-- app/Views/sitemaps/list.php -->
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>사이트맵 목록</title>
</head>
<body>
    <h1>사이트맵 목록</h1>
    <ul>
        <?php foreach ($files as $file): ?>
            <li>
                <a href="<?= base_url("sitemap/download/$file") ?>"><?= esc($file) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
