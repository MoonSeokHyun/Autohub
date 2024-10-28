<?php
// 정비소의 도로명 주소 예시
$road_address = esc($repair_shop['road_address']);

// 구 이름이나 읍 이름을 추출하기 위한 정규 표현식
preg_match('/([가-힣]+구|[가-힣]+읍)/', $road_address, $matches);

// 구 또는 읍 이름을 추출
$district_name = isset($matches[0]) ? $matches[0] : '정비소';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WVK2PC5J');</script>
<!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= esc($repair_shop['repair_shop_name']); ?> 정비소는 <?= esc($district_name); ?>에 위치한 전문 자동차 수리업체입니다. 전화번호, 영업시간 등 상세 정보를 확인하세요.">
    <meta name="keywords" content="<?= esc($repair_shop['repair_shop_name']); ?>, <?= esc($district_name); ?> 정비소, 자동차 수리, 자동차 정비, 서울 정비소">
    <meta property="og:title" content="<?= esc($repair_shop['repair_shop_name']); ?> - <?= esc($district_name); ?> 정비소">
    <meta property="og:description" content="<?= esc($repair_shop['repair_shop_name']); ?>는 <?= esc($district_name); ?> 지역에 있는 전문 정비소로, 신속하고 안전한 자동차 수리를 제공합니다.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="현재 페이지 URL">
    <meta property="og:image" content="이미지 URL">
    <title><?= esc($repair_shop['repair_shop_name']); ?> - <?= esc($district_name); ?> 정비소</title>
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f0ff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #007bff;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        header {
            text-align: center;
            padding: 20px;
            background: #007bff;
            color: #fff;
            border-radius: 5px 5px 0 0;
        }
        .info, .nearby-info {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #007bff;
            background: #f0f8ff;
            border-radius: 5px;
        }
        .info h2, .nearby-info h2 {
            margin-top: 0;
            color: #007bff;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td, .info-table th {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .info-table th {
            background: #e6f7ff;
            color: #007bff;
        }
        #map {
            width: 100%;
            height: 400px;
            margin: 20px 0;
            border: 1px solid #007bff;
            border-radius: 5px;
        }
        .back-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        nav {
            margin-top: 20px;
            text-align: center;
        }
        nav a {
            text-decoration: none;
            color: #007bff;
            margin: 10px;
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
        .comment-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }
        .comment-textarea {
            width: 100%;
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
    <header>
        <h1><?= esc($repair_shop['repair_shop_name']); ?> - <?= esc($district_name); ?> 정비소</h1>
    </header>
    <div class="container">
        <!-- 정비소 기본 정보 출력 -->
        <div class="info">
        <h2>정비소 기본 정보</h2>
            <table class="info-table">
                <tr>
                    <th>정비소명</th>
                    <td><?= esc($repair_shop['repair_shop_name']); ?></td>
                </tr>
                <tr>
                    <th>정비소 종류</th>
                    <td><?= esc($repair_shop['repair_shop_type']); ?>급 정비소</td>
                </tr>
                <tr>
                    <th>도로명 주소</th>
                    <td><?= esc($repair_shop['road_address']); ?></td>
                </tr>
                <tr>
                    <th>지번 주소</th>
                    <td><?= esc($repair_shop['land_lot_address']); ?></td>
                </tr>
                <tr>
                    <th>전화번호</th>
                    <td><?= esc($repair_shop['phone_number']); ?></td>
                </tr>
                <tr>
                    <th>등록일</th>
                    <td><?= esc($repair_shop['registration_date']); ?></td>
                </tr>
                <tr>
                    <th>영업 상태</th>
                    <td>
                        <?php 
                            echo ($repair_shop['business_status'] == 1) ? '영업중' : (($repair_shop['business_status'] == 2) ? '폐업' : '알 수 없음');
                        ?>
                    </td>
                </tr>

                <tr>
                    <th>휴무일</th>
                    <td>법정 공휴일 휴무</td>
                </tr>
                <tr>
                    <th>점심시간</th>
                    <td>12:00 ~ 13:00</td>
                </tr>
                <tr>
                    <th>영업시간</th>
                    <td>09:00 ~ 18:00</td>
                </tr>
                <tr>
                    <th>관리기관명</th>
                    <td><?= esc($repair_shop['management_agency_name']); ?></td>
                </tr>
                <tr>
                    <th>제공업체명</th>
                    <td><?= esc($repair_shop['provider_name']); ?></td>
                </tr>
            </table>
        </div>
        <!-- 돌아가기 버튼 -->
        <a href="<?= site_url('/automobile_repair_shops') ?>" class="back-button">목록으로 돌아가기</a>
        
        <!-- 네이버 지도 -->
        <div id="map"></div>

        <div class="nearby-info">
    <h2>1km 이내 정비소 정보</h2>
    <table class="info-table">
        <thead>
            <tr>
                <th>정비소명</th>
                <th>주소</th>
                <th>전화번호</th>
                <th>거리 (km)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (empty($nearby_shops)) : ?>
                <tr><td colspan="4">근처 정비소 정보가 없습니다.</td></tr>
            <?php else : 
                // 처음 5개의 정비소만 출력하도록 제한
                $nearby_shops = array_slice($nearby_shops, 0, 5); 
                foreach ($nearby_shops as $shop) : ?>
                    <tr onclick="window.location.href='/automobile_repair_shop/<?= esc($shop['id']) ?>'">
                        <td><?= esc($shop['repair_shop_name']); ?></td>
                        <td><?= esc($shop['road_address']); ?></td>
                        <td><?= esc($shop['phone_number']); ?></td>
                        <td><?= round($shop['distance'], 1); ?> km</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>


        <!-- 리뷰 및 평점 기능 -->
        <div class="comments-section">
            <h2>리뷰 남기기 <span>(평균 평점: <?= round($averageRating, 1) ?>)</span></h2>
            <form action="/automobile_repair_shop/saveReview" method="post" class="comment-form" onsubmit="return validateForm()">
                <input type="hidden" name="repair_shop_id" value="<?= esc($repair_shop['id']); ?>">
                <div class="rating" id="star-rating">
                    <span class="rating-label">평점:</span>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="star" data-value="<?= $i; ?>">&#9733;</span>
                    <?php endfor; ?>
                    <input type="hidden" name="rating" id="rating-value">
                </div>
                <textarea name="comment_text" placeholder="리뷰를 등록해주세요!" required class="comment-textarea" id="comment-text"></textarea>
                <button type="submit" class="submit-button">리뷰 등록</button>
            </form>

            <h3>리뷰 목록</h3>
            <div class="comments-list">
                <?php foreach ($reviews as $review): ?>
                    <div class="comment-item">
                        <div class="comment-header">
                            <span class="comment-rating">
                                <?php for ($i = 1; $i <= 5; $i++): 
                                    echo ($i <= $review['rating']) ? '<span class="star selected">&#9733;</span>' : '<span class="star">&#9733;</span>';
                                endfor; ?>
                            </span>
                            <span class="comment-date"><?= date('Y-m-d H:i', strtotime($review['created_at'])); ?></span>
                        </div>
                        <p class="comment-text"><?= esc($review['comment_text']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
    var map = new naver.maps.Map('map', {
        center: new naver.maps.LatLng(<?= esc($repair_shop['latitude']); ?>, <?= esc($repair_shop['longitude']); ?>),
        zoom: 16
    });
    
    // 현재 정비소 마커
    var mainMarker = new naver.maps.Marker({
        position: new naver.maps.LatLng(<?= esc($repair_shop['latitude']); ?>, <?= esc($repair_shop['longitude']); ?>),
        map: map,
        title: '<?= esc($repair_shop['repair_shop_name']); ?>'
    });

    // 주변 정비소 데이터 (PHP 데이터를 JavaScript로 전달)
    var nearbyShops = <?php echo json_encode(array_slice($nearby_shops, 0, 5)); ?>;

    // 주변 정비소 마커 표시
    nearbyShops.forEach(function(shop) {
        var marker = new naver.maps.Marker({
            position: new naver.maps.LatLng(shop.latitude, shop.longitude),
            map: map,
            title: shop.repair_shop_name
        });

        // 정보창 생성
        var infoWindow = new naver.maps.InfoWindow({
            content: '<div style="padding:10px;"><b>' + shop.repair_shop_name + '</b><br>' +
                     '주소: ' + shop.road_address + '<br>' +
                     '전화번호: ' + shop.phone_number + '</div>'
        });

        // 마커에 클릭 이벤트 추가 (정보창 열기)
        naver.maps.Event.addListener(marker, 'click', function() {
            infoWindow.open(map, marker);
        });
    });

    // 별점 선택 기능
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

    // 폼 유효성 검사
    function validateForm() {
        const ratingValue = document.getElementById("rating-value").value;
        const commentText = document.getElementById("comment-text").value.trim();
        return ratingValue && commentText;
    }
</script>

</body>
</html>
