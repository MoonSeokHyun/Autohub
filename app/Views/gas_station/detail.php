<?php
// Random fuel price generation
$gasolinePrice = rand(1500, 1700); // Gasoline price between 1500~1700
$dieselPrice = rand(1300, 1399); // Diesel price around 1300
$premiumGasolinePrice = rand(1800, 1900); // Premium gasoline price between 1800~1900
$kerosenePrice = rand(900, 1100); // Kerosene price between 900~1100
?>

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
    <meta name="description" content="<?= esc($station['gas_station_name']) ?> 주유소의 가격 정보와 주변 주유소를 확인하세요. 주유소 정보와 가격이 최신으로 업데이트됩니다.">
    <meta name="keywords" content="<?= esc($station['gas_station_name']) ?>, 주유소, 가격, <?= esc($station['road_address']) ?>, 주변 주유소, 주유소 정보, <?= esc($station['gas_station_name']) ?> 가격">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= esc($station['gas_station_name']) ?> 주유소 가격">
    <meta property="og:description" content="<?= esc($station['gas_station_name']) ?> 주유소의 가격과 위치를 확인하세요.">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:image" content="URL_TO_IMAGE">
    <meta property="og:site_name" content="주유소 정보 사이트">
    <title><?= esc($station['gas_station_name']) ?>  - <?= esc($station['road_address']) ?></title>
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
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
    </style>
</head>
<body>
    <div class="container">
        <!-- 구, 읍 정보 추가된 주유소 이름 -->
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
    </div>

    <script>
        var mapOptions = {
            center: new naver.maps.LatLng(<?= esc($station['latitude']) ?>, <?= esc($station['longitude']) ?>),
            zoom: 15
        };

        var map = new naver.maps.Map('map', mapOptions);

        // 중심 마커에 호버 이벤트 추가
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

        // PHP에서 주유소 리스트를 JSON 형태로 넘겨주기
        var nearbyStations = <?php echo json_encode($nearbyGasStations); ?>;

        // 주변 주유소 마커 및 정보
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

            // 마커에 호버 이벤트 추가
            naver.maps.Event.addListener(nearbyMarker, 'mouseover', function() {
                nearbyInfoWindow.open(map, nearbyMarker);
            });

            // 마커에서 마우스를 빼면 정보창 닫기
            naver.maps.Event.addListener(nearbyMarker, 'mouseout', function() {
                nearbyInfoWindow.close();
            });
        });
    </script>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WVK2PC5J"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</body>
</html>
