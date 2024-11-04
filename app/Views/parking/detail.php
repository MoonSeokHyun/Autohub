<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-WVK2PC5J');</script>
    <!-- End Google Tag Manager -->
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
        $address = esc($parkingLot['address_road']);
        preg_match('/([가-힣]+(?:구|읍|군))/u', $address, $matches);
        $district = isset($matches[0]) ? $matches[0] : '';
        
        // 평균 평점 계산
        $totalRating = array_sum(array_column($comments, 'rating'));
        $averageRating = count($comments) ? round($totalRating / count($comments), 1) : 0;
    ?>
    <title><?= $district; ?> <?= esc($parkingLot['name']); ?> 주차장</title>
    <meta name="description" content="<?= $district; ?>에 위치한 <?= esc($parkingLot['name']); ?> 주차장의 상세 정보입니다. 주소, 전화번호, 운영시간 등 정보를 확인하세요.">

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $district; ?> <?= esc($parkingLot['name']); ?> 주차장 정보">
    <meta property="og:description" content="<?= $district; ?>에 위치한 <?= esc($parkingLot['name']); ?> 주차장의 상세 정보를 확인하세요.">
    <meta property="og:url" content="<?= current_url(); ?>">
    <meta property="og:image" content="URL_TO_YOUR_IMAGE"> <!-- 사이트 대표 이미지 URL 추가 -->

    <!-- Twitter Card Data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $district; ?> <?= esc($parkingLot['name']); ?> 주차장 정보">
    <meta name="twitter:description" content="<?= $district; ?>에 위치한 <?= esc($parkingLot['name']); ?> 주차장의 상세 정보를 확인하세요.">
    <meta name="twitter:image" content="URL_TO_YOUR_IMAGE">
    <!-- 네이버 지도 API 추가 -->
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
    <style>
        body { font-family: Arial, sans-serif; background-color: #e6f0ff; margin: 0; padding: 0; }
        .container { width: 90%; max-width: 800px; margin: 20px auto; padding: 20px; background: #fff; border: 1px solid #007bff; border-radius: 5px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        header { text-align: center; padding: 20px; background: #007bff; color: #fff; border-radius: 5px 5px 0 0; }
        .info, .nearby-info, .comments-section { margin-bottom: 20px; padding: 15px; border: 1px solid #007bff; background: #f0f8ff; border-radius: 5px; }
        .info h2, .nearby-info h2, .comments-section h2 { margin-top: 0; color: #007bff; }
        .info-table, .nearby-table { width: 100%; border-collapse: collapse; }
        .info-table td, .info-table th, .nearby-table td, .nearby-table th { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .info-table th, .nearby-table th { background: #e6f7ff; color: #007bff; }
        #map { width: 100%; height: 400px; margin: 20px 0; border: 1px solid #007bff; border-radius: 5px; }
        .back-button { display: inline-block; padding: 10px 15px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; margin: 20px 0; text-align: center; }
        .back-button:hover { background-color: #0056b3; }

        /* 평균 평점 및 별점 스타일 */
        .average-rating { display: flex; align-items: center; gap: 5px; font-weight: bold; color: #007bff; margin-bottom: 10px; }
        .rating { display: flex; align-items: center; margin-bottom: 10px; }
        .rating-label { margin-right: 10px; font-weight: bold; color: #007bff; }
        .star { font-size: 24px; color: #ddd; cursor: pointer; transition: color 0.3s ease; }
        .star.selected { color: #ffd700; }

        /* 리뷰 입력 영역 스타일 */
        .comment-form { display: flex; flex-direction: column; gap: 10px; margin-top: 10px; }
        .comment-textarea { width: 98%; height: 80px; padding: 10px; border-radius: 5px; border: 1px solid #ddd; resize: none; font-size: 14px; }
        .submit-button { align-self: flex-end; padding: 8px 16px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease; }
        .submit-button:hover { background-color: #0056b3; }
        .comments-list { margin-top: 20px; }
        .comment-item { padding: 15px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 15px; background-color: #f9f9f9; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); }
        .comment-header { display: flex; justify-content: space-between; font-size: 14px; color: #555; margin-bottom: 8px; }
        .comment-rating { font-weight: bold; color: #007bff; }
        .comment-text { font-size: 16px; color: #333; line-height: 1.4; }
        .error-message { color: red; font-size: 14px; margin-top: -10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <header>
        <h1><?= $district; ?> <?= esc($parkingLot['name']); ?> 주차장</h1>
    </header>
    <div class="container">
        <!-- 돌아가기 버튼 -->
        <a href="/parking" class="back-button">돌아가기</a>

        <!-- 주차장 기본 정보 출력 -->
        <div class="info">
            <h2>주차장 기본 정보</h2>
            <table class="info-table">
                <tr>
                    <th>주차장명</th>
                    <td><?= esc($parkingLot['name']); ?></td>
                </tr>
                <tr>
                    <th>주소</th>
                    <td><?= esc($parkingLot['address_road']); ?></td>
                </tr>
                <tr>
                    <th>전화번호</th>
                    <td><?= esc($parkingLot['phone_number']); ?></td>
                </tr>
                <tr>
                    <th>총 주차 구획 수</th>
                    <td><?= esc($parkingLot['total_spots']); ?></td>
                </tr>
                <tr>
                    <th>주차 요금 정보</th>
                    <td><?= esc($parkingLot['fee_information']); ?></td>
                </tr>
                <tr>
                    <th>운영 시간</th>
                    <td>
                        평일: <?= substr($parkingLot['weekday_start_time'], 0, 5) . ' ~ ' . substr($parkingLot['weekday_end_time'], 0, 5); ?><br>
                        토요일: <?= substr($parkingLot['saturday_start_time'], 0, 5) . ' ~ ' . substr($parkingLot['saturday_end_time'], 0, 5); ?><br>
                        공휴일: <?= substr($parkingLot['holiday_start_time'], 0, 5) . ' ~ ' . substr($parkingLot['holiday_end_time'], 0, 5); ?>
                    </td>
                </tr>
                <tr>
                    <th>특이사항</th>
                    <td><?= esc($parkingLot['special_notes']); ?></td>
                </tr>
            </table>
        </div>

        <!-- 네이버 지도 -->
        <div id="map"></div>

        <!-- 주변 주차장 정보 테이블 -->
        <div class="nearby-info">
            <h2>주변 주차장 정보</h2>
            <table class="nearby-table">
                <thead>
                    <tr>
                        <th>주차장명</th>
                        <th>주소</th>
                        <th>전화번호</th>
                        <th>주차 구획 수</th>
                        <th>거리</th>
                    </tr>
                </thead>
                <tbody id="nearby-parking-list">
                    <?php if (!empty($nearbyParkingLots)): ?>
                        <?php foreach ($nearbyParkingLots as $lot): ?>
                            <tr>
                                <td><?= esc($lot['name']); ?></td>
                                <td><?= esc($lot['address_road']); ?></td>
                                <td><?= esc($lot['phone_number']); ?></td>
                                <td><?= esc($lot['total_spots']); ?></td>
                                <td><?= number_format($lot['distance'], 2); ?> km</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">주변 주차장이 없습니다.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- 평균 평점 표시 -->
        <div class="average-rating">
            <strong>평균 평점:</strong> <?= $averageRating ?> / 5
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="star <?= ($i <= floor($averageRating)) ? 'selected' : (($i - 0.5) === $averageRating ? 'half' : '') ?>">
                    &#9733;
                </span>
            <?php endfor; ?>
        </div>

        <!-- 리뷰 및 평점 기능 -->
        <div class="comments-section">
            <h2>리뷰 남기기</h2>
            <form action="/parking/saveComment" method="post" class="comment-form" onsubmit="return validateForm()">
                <input type="hidden" name="parking_lot_id" value="<?= esc($parkingLot['id']); ?>">
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
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment-item">
                            <div class="comment-header">
                                <span class="comment-rating">
                                    <?php 
                                        for ($i = 1; $i <= 5; $i++): 
                                            echo ($i <= $comment['rating']) ? '<span class="star selected">&#9733;</span>' : '<span class="star">&#9733;</span>';
                                        endfor;
                                    ?>
                                </span>
                                <span class="comment-date"><?= date('Y-m-d H:i', strtotime($comment['created_at'])); ?></span>
                            </div>
                            <p class="comment-text"><?= esc($comment['comment_text']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>댓글이 없습니다.</p>
                <?php endif; ?>
            </div>
        </div>

        <footer style="background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #6c757d;">
            <p>본 데이터는 <a href="https://www.data.go.kr" target="_blank" style="color: #007bff; text-decoration: none;">www.data.go.kr</a>에서 데이터 기반으로 만들어진 웹 사이트입니다.</p>
            <p>이 웹 사이트는 영리 목적으로 만들어진 사이트입니다.</p>
            <p>잘못된 정보는 <a href="mailto:gjqmaoslwj@naver.com" style="color: #007bff; text-decoration: none;">gjqmaoslwj@naver.com</a>으로 문의해 주세요.</p>
        </footer>

        <!-- 지도 및 주변 주차장 스크립트 -->
        <script>
            var currentLat = <?= esc($parkingLot['latitude']); ?>;
            var currentLng = <?= esc($parkingLot['longitude']); ?>;
            var mapOptions = { center: new naver.maps.LatLng(currentLat, currentLng), zoom: 15 };
            var map = new naver.maps.Map('map', mapOptions);
            var mainMarker = new naver.maps.Marker({ position: new naver.maps.LatLng(currentLat, currentLng), map: map, title: "<?= esc($parkingLot['name']); ?>" });
            var mainInfoWindow = new naver.maps.InfoWindow({ content: '<div style="width:200px;text-align:center;padding:10px;"><b><?= esc($parkingLot['name']); ?></b><br><?= esc($parkingLot['address_road']); ?></div>' });
            mainInfoWindow.open(map, mainMarker);

            var nearbyParkingLots = <?php echo json_encode($nearbyParkingLots); ?>;
            nearbyParkingLots.forEach(function(lot) {
                var marker = new naver.maps.Marker({ position: new naver.maps.LatLng(lot.latitude, lot.longitude), map: map, title: lot.name });
                var infoWindow = new naver.maps.InfoWindow({ content: '<div style="width:200px;text-align:center;padding:10px;"><b>' + lot.name + '</b><br>' + lot.address_road + '</div>' });
                marker.addListener('click', function() { infoWindow.open(map, marker); });
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
    </div>
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
