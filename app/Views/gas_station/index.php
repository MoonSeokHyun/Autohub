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
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Car Hub</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f9ff;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        header {
            background: linear-gradient(90deg, #0094ff, #00bfff);
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-bottom: 20px;
            cursor: pointer;
        }
        header h1 {
            font-size: 24px;
            margin: 0;
        }
        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        .search-box {
            margin: 20px 0;
            text-align: center;
        }
        .search-box input[type="text"] {
            width: 70%;
            max-width: 400px;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #0094ff;
            border-radius: 5px;
            outline: none;
            transition: border 0.3s;
        }
        .search-box input[type="text"]:focus {
            border-color: #0056b3;
        }
        .search-box button {
            padding: 12px 18px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .search-box button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #0094ff;
            color: #fff;
            font-size: 18px;
        }
        .table-row {
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .table-row:hover {
            background-color: #f1f1f1;
        }
        .pager {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .pager a {
            margin: 0 5px;
            padding: 10px 15px;
            background-color: #0094ff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-weight: bold;
        }
        .pager a:hover {
            background-color: #0056b3;
        }
        .pager .active {
            background-color: #0056b3;
            pointer-events: none;
            color: #fff;
        }
        /* 지도 스타일 */
        #map {
            width: 100%;
            height: 400px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
    <script>
        let map;
        let markers = []; // 마커를 저장할 배열

        function initMap() {
            const mapOptions = {
                center: new naver.maps.LatLng(37.5665, 126.978), // 기본 위치 (서울)
                zoom: 14,
                scaleControl: true,
                mapTypeControl: true,
                zoomControl: true, // 확대/축소 버튼 추가
                logoControl: false // 네이버 로고 숨김
            };
            map = new naver.maps.Map('map', mapOptions);
            // 현재 위치 기반으로 주변 주유소 마커 추가
            const currentLocation = new naver.maps.LatLng(37.5665, 126.978); // 예시 현재 위치, 실제 위치로 변경 필요
            addMarker(currentLocation, '현재 위치');

            // 주변 주유소 마커 예시 데이터
            const nearbyGasStations = [
                { lat: 37.5705, lng: 126.980, name: '주유소 A', address: '서울시 강남구 역삼동 123', phone: '010-1234-5678' },
                { lat: 37.5645, lng: 126.976, name: '주유소 B', address: '서울시 서초구 방배동 456', phone: '010-2345-6789' },
                { lat: 37.5635, lng: 126.975, name: '주유소 C', address: '서울시 송파구 잠실동 789', phone: '010-3456-7890' },
            ];

            nearbyGasStations.forEach(station => {
                addMarker(new naver.maps.LatLng(station.lat, station.lng), station);
            });
        }

        function addMarker(position, station) {
            const marker = new naver.maps.Marker({
                position: position,
                map: map,
                title: station.name
            });

            // 마커에 정보 표시를 위한 인포윈도우
            const infoWindow = new naver.maps.InfoWindow({
                content: `
                    <div style="padding:10px;">
                        <strong>${station.name}</strong><br>
                        주소: ${station.address}<br>
                        전화번호: ${station.phone}
                    </div>`
            });

            // 마커에 마우스 오버 이벤트 추가
            naver.maps.Event.addListener(marker, 'mouseover', function() {
                infoWindow.open(map, marker);
            });

            // 마커에 마우스 아웃 이벤트 추가
            naver.maps.Event.addListener(marker, 'mouseout', function() {
                infoWindow.close();
            });

            markers.push(marker); // 마커를 배열에 추가
        }

        function goToDetail(id) {
            window.location.href = `<?= base_url('gas_stations/'); ?>${id}`; // 주유소 디테일 페이지로 이동
        }

        function goToHome() {
            window.location.href = "<?= base_url('gas_stations'); ?>"; // 홈으로 이동
        }

document.addEventListener("DOMContentLoaded", function() {
    initMap(); // 지도 초기화
});
</script>
</head>
<body>
<div class="container">
<header onclick="goToHome()">
    <h1>Car Hub</h1>
    <nav>
        <ul>
                <li><a href="/gas_stations">주유소</a></li>
                <li><a href="/automobile_repair_shops">정비소</a></li>
                <li><a href="/">주차장</a></li>
        </ul>
    </nav>
</header>

<div class="search-box">
    <form action="<?= base_url('gas_stations/search'); ?>" method="get">
        <input type="text" name="search" placeholder="주유소 이름 검색..." required>
        <button type="submit">검색</button>
    </form>
</div>

<div id="map"></div>

<table>
    <thead>
        <tr>
            <th>주유소 이름</th>
            <th>주소</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($gasStations)) : ?>
            <?php foreach ($gasStations as $station) : ?>
                <tr class="table-row" onclick="goToDetail(<?= $station['id']; ?>)">
                    <td><?= esc($station['gas_station_name']); ?></td>
                    <td><?= esc($station['road_address']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4">주유소가 없습니다.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<footer style="background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #6c757d;">
    <p>본 데이터는 <a href="https://www.data.go.kr" target="_blank" style="color: #007bff; text-decoration: none;">www.data.go.kr</a>에서 데이터 기반으로 만들어진 웹 사이트입니다.</p>
    <p>이 웹 사이트는 영리 목적으로 만들어진 사이트입니다.</p>
    <p>잘못된 정보는 <a href="mailto:gjqmaoslwj@naver.com" style="color: #007bff; text-decoration: none;">gjqmaoslwj@naver.com</a>으로 문의해 주세요.</p>
</footer>

<!-- 페이지네이션 -->
<div class="pager">
            <?= $pager->links('gasStationsGroup', 'default_full') ?>
        </div>
</div>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WVK2PC5J"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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