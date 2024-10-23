<?php
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>'; // XML 선언문 출력
?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($sitemaps as $sitemap): ?>
    <sitemap>
        <loc><?= $sitemap ?></loc> <!-- esc() 함수 제거 -->
        <lastmod><?= date('Y-m-d\TH:i:sP') ?></lastmod> <!-- ISO 8601 형식 -->
    </sitemap>
    <?php endforeach; ?>
</sitemapindex>
