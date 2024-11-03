<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-WVK2PC5J');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Hub - 정비소, 주유소, 주차장 정보 통합 웹사이트</title>
    <meta name="description" content="Car Hub에서 서울 및 전국의 최신 정비소, 주유소, 주차장 정보를 확인하세요. 리뷰와 평점을 통해 최적의 정비소를 쉽게 찾으세요.">

    <meta name="keywords" content="정비소, 주유소, 주차장, 서울 정비소, 자동차 관리, 리뷰, 평점, 주차 정보, Car Hub">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= current_url() ?>" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Car Hub - 서울 정비소와 주유소 정보">
    <meta property="og:description" content="서울 및 전국의 정비소와 주유소 정보를 최신 상태로 제공합니다. 고객 리뷰를 통해 신뢰할 수 있는 정비소를 찾으세요.">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:image" content="URL_TO_IMAGE">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Car Hub - 정비소 정보">
    <meta name="twitter:description" content="서울과 전국의 최신 정비소 정보를 확인하세요. 사용자 리뷰로 신뢰도 높은 정보를 제공합니다.">
    <meta name="twitter:image" content="URL_TO_IMAGE">

    <!-- Schema.org JSON-LD 구조화 데이터 -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "AutoRepair",
      "name": "Car Hub",
      "url": "<?= current_url() ?>",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "서울",
        "addressCountry": "KR"
      },
      "description": "서울과 전국의 정비소, 주유소, 주차장 정보를 제공합니다.",
      "image": "URL_TO_IMAGE"
    }
    </script>
    <style>
        /* 기본 스타일 */
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background-color: #f0f9ff; }
        .container { width: 90%; max-width: 1200px; margin: auto; padding: 20px; }
        header { background: linear-gradient(90deg, #0094ff, #00bfff); color: #fff; padding: 20px; text-align: center; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); margin-bottom: 20px; }
        header h1 { font-size: 24px; margin: 0; }
        nav ul { display: flex; justify-content: center; list-style: none; padding: 0; }
        nav ul li { margin: 0 15px; }
        nav ul li a { color: #fff; text-decoration: none; font-weight: bold; }

        /* 검색창 스타일 */
        .search-box { margin: 20px 0; text-align: center; }
        .search-box input[type="text"] { width: 70%; max-width: 400px; padding: 12px; font-size: 16px; border: 1px solid #0094ff; border-radius: 5px; outline: none; transition: border 0.3s; }
        .search-box button { padding: 12px 18px; font-size: 16px; cursor: pointer; background-color: #007bff; color: #fff; border: none; border-radius: 5px; }

        /* 슬라이드 스타일 */
        .recent-slides { display: flex; overflow: hidden; width: 100%; position: relative; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); background: #fff; }
        .recent-slide { min-width: 100%; transition: transform 0.5s ease; }
        .card { text-align: center; padding: 20px; }
        .card h3 { font-size: 18px; color: #333; margin-bottom: 5px; }
        .card p { color: #555; margin: 5px 0; }

        /* 섹션 및 테이블 스타일 */
        section { margin-top: 40px; }
        section h2 { font-size: 20px; margin-bottom: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); margin-bottom: 20px; }
        th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
        th { background-color: #0094ff; color: #fff; font-size: 16px; }
        .clickable-row { cursor: pointer; }

        /* 페이지네이션 */
        .pager { display: flex; justify-content: center; margin: 20px 0; }
        .pager a { margin: 0 5px; padding: 10px 15px; background-color: #0094ff; color: #fff; text-decoration: none; border-radius: 5px; }
        
        /* 지도 */
        #map { width: 100%; height: 400px; margin-top: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }

        /* 리뷰 스타일 */
        .reviews { margin: 20px 0; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
        .review-card { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .review-card:last-child { border-bottom: none; }
        .review-title { font-weight: bold; color: #0094ff; margin-bottom: 5px; }
        .review-text { color: #555; }
        .review-rating { color: #ffa500; font-weight: bold; }
    </style>
</head>
<body>
    <header>
        <h1>Car Hub</h1>
        <nav>
            <ul>
                <li><a href="/gas_stations">주유소</a></li>
                <li><a href="/automobile_repair_shops">정비소</a></li>
                <li><a href="/">주차장</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <!-- 검색창 -->
        <div class="search-box">
            <form action="<?= base_url('automobile_repair_shops'); ?>" method="get">
                <input type="text" id="search" name="search" placeholder="정비소 이름 또는 주소 검색" required>
                <button type="submit">검색</button>
            </form>
        </div>

        <!-- 지도 -->
        <div id="map"></div>

        <!-- 최근 추가된 정비소 섹션 -->
        <section>
    <h2>최근 추가된 정비소</h2>
    <div class="recent-slides" id="recent-slides">
        <?php foreach ($recentRepairShops as $shop): ?>
            <div class="recent-slide card" onclick="window.location.href='/automobile_repair_shop/<?= isset($shop['id']) ? esc($shop['id']) : '' ?>'">
                <h3><?= isset($shop['repair_shop_name']) ? esc($shop['repair_shop_name']) : '정보 없음' ?></h3>
                <p><?= isset($shop['road_address']) ? esc($shop['road_address']) : '주소 없음' ?></p>
                <p>추가일: <?= date('Y-m-d') ?></p> <!-- 매일 최신 일자로 표시 -->
            </div>
        <?php endforeach; ?>
    </div>
</section>


        <!-- 인기 정비소 섹션 -->
        <section>
            <h2>인기 정비소</h2>
            <table>
                <thead>
                    <tr>
                        <th>정비소명</th>
                        <th>리뷰 개수</th>
                        <th>평균 별점</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($popularRepairShops as $popularShop): ?>
                    <tr class="clickable-row" onclick="window.location.href='/automobile_repair_shop/<?= isset($popularShop['repair_shop_id']) ? esc($popularShop['repair_shop_id']) : '' ?>'">
                        <td><?= isset($popularShop['repair_shop_name']) ? esc($popularShop['repair_shop_name']) : '정보 없음' ?></td>
                        <td><?= isset($popularShop['review_count']) ? esc($popularShop['review_count']) : '0' ?></td>
                        <td><?= isset($popularShop['average_rating']) ? number_format($popularShop['average_rating'], 1) . ' 점' : 'N/A' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- 최근 추가된 리뷰 섹션 -->
        <section class="reviews">
            <h2>최근 추가된 리뷰</h2>
            <?php foreach ($recentReviews as $review): ?>
                <div class="review-card clickable-row" onclick="window.location.href='/automobile_repair_shop/<?= isset($review['repair_shop_id']) ? esc($review['repair_shop_id']) : '' ?>'">
                    <div class="review-title"><?= isset($review['repair_shop_name']) ? esc($review['repair_shop_name']) : '정보 없음' ?> - 
                        <span class="review-rating"><?= isset($review['rating']) ? esc($review['rating']) : 'N/A' ?>점</span>
                    </div>
                    <div class="review-text"><?= isset($review['comment_text']) ? esc($review['comment_text']) : '내용 없음' ?></div>
                    <small>작성일: <?= isset($review['created_at']) ? date('Y-m-d', strtotime($review['created_at'])) : '알 수 없음' ?></small>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- 정비소 목록 섹션 -->
        <section>
            <h2>정비소 목록</h2>
            <table>
                <thead>
                    <tr>
                        <th>정비소명</th>
                        <th>정비소 종류</th>
                        <th>도로명 주소</th>
                        <th>전화번호</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($repair_shops)): ?>
                        <?php foreach ($repair_shops as $shop): ?>
                        <tr class="clickable-row" onclick="window.location.href='/automobile_repair_shop/<?= isset($shop['id']) ? esc($shop['id']) : '' ?>'">
                            <td><?= isset($shop['repair_shop_name']) ? esc($shop['repair_shop_name']) : '정보 없음' ?></td>
                            <td><?= isset($shop['repair_shop_type']) ? esc($shop['repair_shop_type']) . '급' : '정보 없음' ?></td>
                            <td><?= isset($shop['road_address']) ? esc($shop['road_address']) : '주소 없음' ?></td>
                            <td><?= isset($shop['phone_number']) ? esc($shop['phone_number']) : '전화번호 없음' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">등록된 정비소가 없습니다.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- 페이지네이션 -->
            <div class="pager">
                <?= $pager->links(); ?>
            </div>
        </section>
    </div>

    <footer style="background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #6c757d;">
    <p>본 데이터는 <a href="https://www.data.go.kr" target="_blank" style="color: #007bff; text-decoration: none;">www.data.go.kr</a>에서 데이터 기반으로 만들어진 웹 사이트입니다.</p>
    <p>이 웹 사이트는 영리 목적으로 만들어진 사이트입니다.</p>
    <p>잘못된 정보는 <a href="mailto:gjqmaoslwj@naver.com" style="color: #007bff; text-decoration: none;">gjqmaoslwj@naver.com</a>으로 문의해 주세요.</p>
</footer>

    <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
    <script>
        var mapOptions = {
            center: new naver.maps.LatLng(37.5665, 126.9780),
            zoom: 15
        };
        var map = new naver.maps.Map('map', mapOptions);

        <?php if (isset($nearbyRepairShops) && !empty($nearbyRepairShops)): ?>
            var nearbyRepairShops = <?= json_encode($nearbyRepairShops) ?>;
            nearbyRepairShops.forEach(function(shop) {
                var marker = new naver.maps.Marker({
                    position: new naver.maps.LatLng(shop.latitude, shop.longitude),
                    map: map,
                    title: shop.repair_shop_name || "알 수 없는 정비소"
                });

                var infoWindow = new naver.maps.InfoWindow({
                    content: `<div style="padding:10px; font-size:14px;">${shop.repair_shop_name || "알 수 없는 정비소"}</div>`
                });

                naver.maps.Event.addListener(marker, 'mouseover', function() {
                    infoWindow.open(map, marker);
                });

                naver.maps.Event.addListener(marker, 'mouseout', function() {
                    infoWindow.close();
                });
            });
        <?php endif; ?>

        // 카드 슬라이드 자동 전환
        let currentSlide = 0;
        const slides = document.querySelectorAll('.recent-slide');
        function showSlide() {
            slides.forEach((slide, index) => {
                slide.style.transform = `translateX(-${currentSlide * 100}%)`;
            });
            currentSlide = (currentSlide + 1) % slides.length;
        }
        setInterval(showSlide, 1000);
    </script>
    	
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
if(!wcs_add) var wcs_add = {};
wcs_add["wa"] = "d453c02d83e61";
if(window.wcs) {
wcs_do();
}
</script>
</body>
</html>
