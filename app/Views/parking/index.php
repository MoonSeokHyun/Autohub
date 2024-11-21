<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="google-site-verification" content="vTa0kwUBtDAIFY_RbTOw4p-LpneLpkhxTYAWYqNwAog" />
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464"
    crossorigin="anonymous"></script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-WVK2PC5J');</script>
    <!-- End Google Tag Manager -->
    <meta name="description" content="Car Hub - 최신 주차장 정보, 인기 주유소, 정비소 정보 및 리뷰를 제공하여 차량 관리에 도움을 드리는 웹사이트입니다. 사용자 리뷰와 평점으로 신뢰성 있는 주차장과 정비소 정보를 쉽게 찾아보세요.">
    <meta name="naver-site-verification" content="7a0d49f3fd680b5f4ab77f8edfd3deb13ee30f11" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <title>Car Hub - 주차장</title>
    <link rel="stylesheet" href="path/to/your/style.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
    <style>
        /* 기본 스타일 */
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background-color: #f0f9ff; }
        .container { width: 90%; max-width: 1200px; margin: auto; padding: 20px; }
        header { background: linear-gradient(90deg, #0094ff, #00bfff); color: #fff; padding: 20px; text-align: center; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); margin-bottom: 20px; }
        header h1 { font-size: 24px; margin: 0; }
        nav ul { display: flex; justify-content: center; list-style: none; padding: 0; }
        nav ul li { margin: 0 15px; }
        nav ul li a { color: #fff; text-decoration: none; font-weight: bold; }
        
        .search-box { margin: 20px 0; text-align: center; }
        .search-box input[type="text"] { width: 70%; max-width: 400px; padding: 12px; font-size: 16px; border: 1px solid #0094ff; border-radius: 5px; outline: none; transition: border 0.3s; }
        .search-box button { padding: 12px 18px; font-size: 16px; cursor: pointer; background-color: #007bff; color: #fff; border: none; border-radius: 5px; }
        
        .recent-slides { display: flex; overflow: hidden; width: 100%; position: relative; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); background: #fff; }
        .recent-slide { min-width: 100%; transition: transform 0.5s ease; }
        .card { text-align: center; padding: 20px; }
        .card h3 { font-size: 18px; color: #333; margin-bottom: 5px; }
        .card p { color: #555; margin: 5px 0; }

        section { margin-top: 40px; }
        section h2 { font-size: 20px; margin-bottom: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); margin-bottom: 20px; }
        th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
        th { background-color: #0094ff; color: #fff; font-size: 16px; }
        
        .pager { display: flex; justify-content: center; margin: 20px 0; }
        .pager a { margin: 0 5px; padding: 10px 15px; background-color: #0094ff; color: #fff; text-decoration: none; border-radius: 5px; }
        #map { width: 100%; height: 400px; margin-top: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }

        .reviews { margin: 20px 0; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
        .review-card { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .review-card:last-child { border-bottom: none; }
        .review-title { font-weight: bold; color: #0094ff; margin-bottom: 5px; }
        .review-text { color: #555; }
        .review-rating { color: #ffa500; font-weight: bold; }
        .clickable-row { cursor: pointer; }
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
            <form action="<?= base_url('parking/search'); ?>" method="get">
                <input type="text" id="search" name="search" placeholder="주차장 이름 또는 주소 검색" required>
                <button type="submit">검색</button>
            </form>
        </div>

        <!-- 지도 -->
        <div id="map"></div>

        <!-- 최근 추가된 주차장 섹션 -->
        <section>
            <h2>최근 추가된 주차장</h2>
            <div class="recent-slides" id="recent-slides">
                <?php foreach ($recentParkingLots as $lot): ?>
                    <div class="recent-slide card" onclick="window.location.href='/parking/detail/<?= esc($lot['id']) ?>'">
                        <h3><?= esc($lot['name']) ?></h3>
                        <p><?= esc($lot['address_road']) ?></p>
                        <p>추가일: <?= date('Y-m-d') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- 인기 주차장 섹션 -->
        <section>
            <h2>인기 주차장</h2>
            <table>
                <thead>
                    <tr>
                        <th>주차장명</th>
                        <th>리뷰 개수</th>
                        <th>평균 별점</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($popularParkingLots as $popularLot): ?>
                    <tr class="clickable-row" onclick="window.location.href='/parking/detail/<?= esc($popularLot['id']) ?>'">
                        <td><?= esc($popularLot['name']) ?></td>
                        <td><?= esc($popularLot['review_count']) ?></td>
                        <td><?= number_format($popularLot['average_rating'], 1) ?> 점</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section class="reviews">
            <h2>최근 추가된 리뷰</h2>
            <?php foreach ($recentReviews as $review): ?>
                <div class="review-card clickable-row" onclick="window.location.href='/parking/detail/<?= esc($review['parking_lot_id']) ?>'">
                    <div class="review-title"><?= esc($review['parking_lot_name']) ?> - <span class="review-rating"><?= esc($review['rating']) ?>점</span></div>
                    <div class="review-text"><?= esc($review['comment_text']) ?></div>
                    <small>작성일: <?= date('Y-m-d', strtotime($review['created_at'])) ?></small>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- 주차장 목록 섹션 -->
        <section>
            <h2>주차장 목록</h2>
            <table>
                <thead>
                    <tr>
                        <th>주차장명</th>
                        <th>주차구획수</th>
                        <th>주차기본요금</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($parkingLots)): ?>
                        <?php foreach ($parkingLots as $lot): ?>
                        <tr class="clickable-row" onclick="window.location.href='/parking/detail/<?= esc($lot['id']) ?>'">
                            <td><?= esc($lot['name']) ?></td>
                            <td><?= esc($lot['total_spots']) ?></td>
                            <td><?= esc($lot['basic_fee']) == 0 ? '무료' : number_format(esc($lot['basic_fee'])) . ' 원'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">등록된 주차장이 없습니다.</td>
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


    <script>
        var mapOptions = {
            center: new naver.maps.LatLng(37.5665, 126.9780),
            zoom: 15
        };

        var map = new naver.maps.Map('map', mapOptions);

        // 1km 이내 주차장 마커 추가
        var nearbyParkingLots = <?php echo json_encode($nearbyParkingLots); ?>;
        nearbyParkingLots.forEach(function(lot) {
            var marker = new naver.maps.Marker({
                position: new naver.maps.LatLng(lot.latitude, lot.longitude),
                map: map,
                title: lot.name
            });

            // 마커에 마우스 오버 이벤트 리스너 추가
            var infoWindow = new naver.maps.InfoWindow({
                content: `<div style="padding:10px; font-size:14px;">${lot.name}</div>`
            });

            naver.maps.Event.addListener(marker, 'mouseover', function() {
                infoWindow.open(map, marker);
            });

            naver.maps.Event.addListener(marker, 'mouseout', function() {
                infoWindow.close();
            });
        });

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
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WVK2PC5J" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464"
    crossorigin="anonymous"></script>
    <script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
    <script type="text/javascript">
    if(!wcs_add) var wcs_add = {};
    wcs_add["wa"] = "d453c02d83e61";
    if(window.wcs) { wcs_do(); }
    </script>
    
</body>
</html>
