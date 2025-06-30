<?php
// Random fuel price generation
$gasolinePrice = rand(1500, 1700);
$dieselPrice = rand(1300, 1399);
$premiumGasolinePrice = rand(1800, 1900);
$kerosenePrice = rand(900, 1100);

// 평점 평균 계산 (reviews 배열이 비어있지 않은 경우에만)
$averageRating = 0;
if (!empty($reviews)) {
    $sumRating = array_sum(array_column($reviews, 'rating'));
    $averageRating = $sumRating / count($reviews);
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464"
crossorigin="anonymous"></script>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WVK2PC5J');</script>
<!-- End Google Tag Manager -->
<meta charset="UTF-8">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= esc($station['gas_station_name']) ?> 주유소의 최신 유가 정보와 주변 주유소 위치를 확인하세요.">
    <meta name="keywords" content="<?= esc($station['gas_station_name']) ?>, 주유소, 가격 정보, <?= esc($station['road_address']) ?>, 주변 주유소">
    
    <!-- Open Graph meta tags for social media sharing -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= esc($station['gas_station_name']) ?> 주유소 가격 정보">
    <meta property="og:description" content="<?= esc($station['gas_station_name']) ?> 주유소의 유가와 위치 정보를 확인하세요.">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:image" content="URL_TO_IMAGE"> <!-- 주유소 대표 이미지 URL 추가 -->
    <meta property="og:site_name" content="Car Hub - 주유소 정보 사이트">

    <!-- Twitter meta tags for social media sharing -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= esc($station['gas_station_name']) ?> 주유소 가격 정보">
    <meta name="twitter:description" content="<?= esc($station['gas_station_name']) ?> 주유소의 유가와 위치 정보를 확인하세요.">
    <meta name="twitter:image" content="URL_TO_IMAGE">

    <title><?= esc($station['gas_station_name']) ?>  - <?= esc($station['road_address']) ?></title>
<!--     <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script> -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "GasStation",
      "name": "<?= esc($station['gas_station_name']) ?>",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?= esc($station['road_address']) ?>",
        "addressLocality": "서울",
        "addressCountry": "KR"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": "<?= esc($station['latitude']) ?>",
        "longitude": "<?= esc($station['longitude']) ?>"
      },
      "url": "<?= current_url() ?>"
    }
    </script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f9ff;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        h1 {
            text-align: center;
            color: #0094ff;
        }
        .sub-title {
            text-align: center;
            font-size: 18px;
            color: #666;
            margin-top: 10px;
        }
        .detail-info {
            margin: 20px 0;
            font-size: 18px;
        }
        .detail-info p {
            margin: 10px 0;
        }
        .back-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        #map {
            width: 100%;
            height: 300px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #0094ff;
            color: white;
        }

        /* 리뷰 스타일 */
        .comments-section {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #007bff;
            background: #f0f8ff;
            border-radius: 5px;
        }
        .rating {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .rating-label {
            margin-right: 10px;
            font-weight: bold;
            color: #007bff;
        }
        .star {
            font-size: 24px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .star.selected {
            color: #ffd700;
        }
        .average-rating {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        .comment-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }
        .comment-textarea {
            width: 98%;
            height: 80px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            resize: none;
            font-size: 14px;
        }
        .submit-button {
            align-self: flex-end;
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .submit-button:hover {
            background-color: #0056b3;
        }
        .comments-list {
            margin-top: 20px;
        }
        .comment-item {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .comment-header {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }
        .comment-rating {
            font-weight: bold;
            color: #007bff;
        }
        .comment-text {
            font-size: 16px;
            color: #333;
            line-height: 1.4;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= esc($station['gas_station_name']) ?> </h1>
        <p class="sub-title"><?= esc($station['road_address']) ?>에 위치한 주유소입니다.</p>
        
        <!-- 유가 정보 테이블 -->
        <h2>유가 정보 <span style="font-size: 12px; color: #888;">(실제 유가와 차이가 있을 수 있습니다.)</span></h2>
        <table>
            <tr>
                <th>유형</th>
                <th>가격</th>
            </tr>
            <tr>
                <td>가솔린</td>
                <td><?= number_format($gasolinePrice) ?> 원</td>
            </tr>
            <tr>
                <td>경유</td>
                <td><?= number_format($dieselPrice) ?> 원</td>
            </tr>
            <tr>
                <td>고급 휘발유</td>
                <td><?= number_format($premiumGasolinePrice) ?> 원</td>
            </tr>
            <tr>
                <td>등유</td>
                <td><?= number_format($kerosenePrice) ?> 원</td>
            </tr>
        </table>

        <div id="map"></div>
        
        <a href="<?= site_url('gas_stations') ?>" class="back-button">목록으로 돌아가기</a>
        
        <h2>주변 3km 이내 주유소</h2>
        <table>
            <thead>
                <tr>
                    <th>주유소 이름</th>
                    <th>도로명 주소</th>
                    <th>거리 (km)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nearbyGasStations as $nearbyStation): ?>
                    <tr>
                        <td><?= esc($nearbyStation['gas_station_name']) ?></td>
                        <td><?= esc($nearbyStation['road_address']) ?></td>
                        <td><?= number_format($nearbyStation['distance'], 2) ?> km</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- 리뷰 및 평점 기능 -->
        <div class="comments-section">
            <h2>리뷰 남기기</h2>
            
            <!-- 평균 평점 표시 -->
            <div class="average-rating">
                <strong>평균 평점:</strong>
                <span>
                    <?php
                        $roundedRating = round($averageRating * 2) / 2; // 반올림하여 평균 평점 표시
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $roundedRating) {
                                echo '<span class="star selected">&#9733;</span>'; // 선택된 별
                            } elseif ($i - 0.5 == $roundedRating) {
                                echo '<span class="star selected">&#9733;</span>'; // 반 별
                            } else {
                                echo '<span class="star">&#9733;</span>'; // 빈 별
                            }
                        }
                    ?>
                    (<?= number_format($averageRating, 1) ?>/5)
                </span>
            </div>

            <form action="/gas_station/saveComment" method="post" class="comment-form" onsubmit="return validateForm()">
                <input type="hidden" name="station_id" value="<?= esc($station['id']); ?>">
                <div class="rating" id="star-rating">
                    <span class="rating-label">평점:</span>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="star" data-value="<?= $i; ?>">&#9733;</span>
                    <?php endfor; ?>
                    <input type="hidden" name="rating" id="rating-value">
                </div>
                <div id="rating-error" class="error-message" style="display: none;">평점이 누락되었습니다.</div>
                <textarea name="comment_text" placeholder="리뷰를 등록해주세요!" required class="comment-textarea" id="comment-text"></textarea>
                <div id="comment-error" class="error-message" style="display: none;">리뷰가 누락되었습니다.</div>
                <button type="submit" class="submit-button">리뷰 등록</button>
            </form>
            
            <!-- 리뷰 목록 -->
            <h3>리뷰 목록</h3>
            <div class="comments-list">
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="comment-item">
                            <div class="comment-header">
                                <span class="comment-rating">
                                    <?php 
                                        for ($i = 1; $i <= 5; $i++): 
                                            echo ($i <= $review['rating']) ? '<span class="star selected">&#9733;</span>' : '<span class="star">&#9733;</span>';
                                        endfor;
                                    ?>
                                </span>
                                <span class="comment-date"><?= date('Y-m-d H:i', strtotime($review['created_at'])); ?></span>
                            </div>
                            <p class="comment-text"><?= esc($review['comment_text']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>댓글이 없습니다.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <footer style="background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #6c757d;">
    <p>본 데이터는 <a href="https://www.data.go.kr" target="_blank" style="color: #007bff; text-decoration: none;">www.data.go.kr</a>에서 데이터 기반으로 만들어진 웹 사이트입니다.</p>
    <p>이 웹 사이트는 영리 목적으로 만들어진 사이트입니다.</p>
    <p>잘못된 정보는 <a href="mailto:gjqmaoslwj@naver.com" style="color: #007bff; text-decoration: none;">gjqmaoslwj@naver.com</a>으로 문의해 주세요.</p>
</footer>

    <script>
        var mapOptions = {
            center: new naver.maps.LatLng(<?= esc($station['latitude']) ?>, <?= esc($station['longitude']) ?>),
            zoom: 15
        };

        var map = new naver.maps.Map('map', mapOptions);

        var marker = new naver.maps.Marker({
            position: map.getCenter(),
            map: map
        });

        var infoWindow = new naver.maps.InfoWindow({
            content: ''
        });

        naver.maps.Event.addListener(marker, 'mouseover', function() {
            infoWindow.setContent('<div><strong><?= esc($station['gas_station_name']) ?></strong><br>' +
                                  '위치: <?= esc($station['road_address']) ?><br>' +
                                  '전화번호: <?= esc($station['phone_number']) ?></div>');
            infoWindow.open(map, marker);
        });

        naver.maps.Event.addListener(marker, 'mouseout', function() {
            infoWindow.close();
        });

        var nearbyStations = <?php echo json_encode($nearbyGasStations); ?>;

        nearbyStations.forEach(function(station) {
            var nearbyMarker = new naver.maps.Marker({
                position: new naver.maps.LatLng(station.latitude, station.longitude),
                map: map
            });

            var nearbyInfoWindow = new naver.maps.InfoWindow({
                content: '<div><strong>' + station.gas_station_name + '</strong><br>' +
                         '주소: ' + station.road_address + '<br>' +
                         '거리: ' + station.distance.toFixed(2) + ' km</div>'
            });

            naver.maps.Event.addListener(nearbyMarker, 'mouseover', function() {
                nearbyInfoWindow.open(map, nearbyMarker);
            });

            naver.maps.Event.addListener(nearbyMarker, 'mouseout', function() {
                nearbyInfoWindow.close();
            });
        });

        document.querySelectorAll('#star-rating .star').forEach(star => {
            star.addEventListener('click', function() {
                const ratingValue = this.getAttribute('data-value');
                document.getElementById('rating-value').value = ratingValue;
                document.querySelectorAll('#star-rating .star').forEach(s => s.classList.remove('selected'));
                
                for (let i = 0; i < ratingValue; i++) {
                    document.querySelectorAll('#star-rating .star')[i].classList.add('selected');
                }
            });
        });

        function validateForm() {
            const ratingValue = document.getElementById("rating-value").value;
            const commentText = document.getElementById("comment-text").value.trim();
            let isValid = true;

            document.getElementById("rating-error").style.display = ratingValue ? "none" : "block";
            document.getElementById("comment-error").style.display = commentText ? "none" : "block";

            if (!ratingValue) isValid = false;
            if (!commentText) isValid = false;

            return isValid;
        }
    </script>
    	
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
if(!wcs_add) var wcs_add = {};
wcs_add["wa"] = "d453c02d83e61";
if(window.wcs) {
wcs_do();
}
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6686738239613464"
     crossorigin="anonymous"></script>
</body>
</html>
