<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WVK2PC5J');</script>
<!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- 동적으로 제목과 메타 설명 설정 -->
    <?php
        // 도로명 주소에서 구/읍/군 이름 추출 (정규식 사용)
        $address = esc($parkingLot['address_road']);
        
        // 구, 읍, 군 이름을 추출하기 위한 정규식
        preg_match('/([가-힣]+(?:구|읍|군))/u', $address, $matches);
        
        // 추출된 구/읍/군 이름이 있으면 사용, 없으면 '주차장'으로 설정
        $district = isset($matches[0]) ? $matches[0] : '';
    ?>
    <title><?= $district; ?> <?= esc($parkingLot['name']); ?> 주차장</title>
    <meta name="description" content="<?= $district; ?>에 위치한 <?= esc($parkingLot['name']); ?> 주차장의 상세 정보입니다. 주소, 전화번호, 운영시간 등 정보를 확인하세요.">

    <!-- 네이버 지도 API 추가 -->
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f0ff; /* 배경 색상 변경 */
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 800px; /* 최대 너비 설정 */
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #007bff; /* 경계 색상 변경 */
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); /* 그림자 추가 */
        }
        header {
            text-align: center;
            padding: 20px;
            background: #007bff; /* 헤더 배경 색상 변경 */
            color: #fff;
            border-radius: 5px 5px 0 0;
        }
        .info, .nearby-info {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #007bff; /* 정보 박스 경계 색상 변경 */
            background: #f0f8ff; /* 정보 박스 배경 색상 변경 */
            border-radius: 5px;
        }
        .info h2, .nearby-info h2 {
            margin-top: 0;
            color: #007bff; /* 제목 색상 변경 */
        }
        .info-table, .nearby-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td, .info-table th, .nearby-table td, .nearby-table th {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .info-table th, .nearby-table th {
            background: #e6f7ff; /* 테이블 헤더 배경 색상 변경 */
            color: #007bff; /* 테이블 헤더 글자 색상 변경 */
        }
        #map {
            width: 100%;
            height: 400px;
            margin: 20px 0;
            border: 1px solid #007bff; /* 지도 경계 색상 변경 */
            border-radius: 5px;
        }
        .back-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff; /* 버튼 배경 색상 */
            color: #fff; /* 버튼 글자 색상 */
            text-decoration: none;
            border-radius: 5px; /* 버튼 모서리 둥글게 */
            margin: 20px 0;
            text-align: center;
        }
        .back-button:hover {
            background-color: #0056b3; /* 버튼 호버 색상 */
        }
    </style>
</head>
<body>
    <header>
        <h1><?= $district; ?> <?= esc($parkingLot['name']); ?> 주차장</h1>
    </header>
    <div class="container">
        <!-- 돌아가기 버튼 -->
        <a href="javascript:history.back()" class="back-button">돌아가기</a>

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
                        평일: <?= esc($parkingLot['weekday_start_time']) . ' - ' . esc($parkingLot['weekday_end_time']); ?><br>
                        토요일: <?= esc($parkingLot['saturday_start_time']) . ' - ' . esc($parkingLot['saturday_end_time']); ?><br>
                        공휴일: <?= esc($parkingLot['holiday_start_time']) . ' - ' . esc($parkingLot['holiday_end_time']); ?>
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

        <!-- 지도 및 주변 주차장 스크립트 -->
        <script>
            // 주차장 좌표 설정
            var currentLat = <?= esc($parkingLot['latitude']); ?>;
            var currentLng = <?= esc($parkingLot['longitude']); ?>;

            // 네이버 지도 초기화
            var mapOptions = {
                center: new naver.maps.LatLng(currentLat, currentLng),
                zoom: 15
            };
            var map = new naver.maps.Map('map', mapOptions);

            // 현재 주차장 마커 생성
            var mainMarker = new naver.maps.Marker({
                position: new naver.maps.LatLng(currentLat, currentLng),
                map: map,
                title: "<?= esc($parkingLot['name']); ?>"
            });

            // 현재 주차장 정보창 생성
            var mainInfoWindow = new naver.maps.InfoWindow({
                content: '<div style="width:200px;text-align:center;padding:10px;"><b><?= esc($parkingLot['name']); ?></b><br><?= esc($parkingLot['address_road']); ?></div>'
            });
            mainInfoWindow.open(map, mainMarker);

            // 주변 주차장 마커 및 정보창 표시 (이 예시에서는 고정된 주변 주차장 목록을 사용)
            var nearbyParkingLots = <?php echo json_encode($nearbyParkingLots); ?>;
            nearbyParkingLots.forEach(function(lot) {
                var marker = new naver.maps.Marker({
                    position: new naver.maps.LatLng(lot.latitude, lot.longitude),
                    map: map,
                    title: lot.name
                });
                var infoWindow = new naver.maps.InfoWindow({
                    content: '<div style="width:200px;text-align:center;padding:10px;"><b>' + lot.name + '</b><br>' + lot.address_road + '</div>'
                });
                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });
            });
        </script>
    </div>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WVK2PC5J"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</body>
</html>
