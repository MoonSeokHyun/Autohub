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
        <input type="text" id="search" name="search" placeholder="정비소 이름 또는 주소 검색" value="<?= esc($search); ?>" required>
        <button type="submit">검색</button>
    </form>
</div>

        <!-- 네이버 지도 -->
        <div id="map"></div>

        <!-- 정비소 목록 테이블 -->
        <table>
            <thead>
                <tr>
                    <th>정비소 이름</th>
                    <th>정비소 종류</th>
                    <th>도로명 주소</th>
                    <th>전화번호</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($repair_shops)): ?>
                    <?php foreach ($repair_shops as $shop): ?>
                    <tr class="table-row" onclick="window.location.href='/automobile_repair_shop/<?= esc($shop['id']) ?>'">
                        <td><?= esc($shop['repair_shop_name']) ?></td>
                        <td><?= esc($shop['repair_shop_type']) ?>급</td>
                        <td><?= esc($shop['road_address']) ?></td>
                        <td><?= esc($shop['phone_number']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">정비소가 없습니다.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- 페이지네이션 -->
        <div class="pager">
            <?= $pager->links(); ?>
        </div>
    </div>

    <footer style="background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #6c757d;">
    <p>본 데이터는 <a href="https://www.data.go.kr" target="_blank" style="color: #007bff; text-decoration: none;">www.data.go.kr</a>에서 데이터 기반으로 만들어진 웹 사이트입니다.</p>
    <p>이 웹 사이트는 영리 목적으로 만들어진 사이트입니다.</p>
    <p>잘못된 정보는 <a href="mailto:gjqmaoslwj@naver.com" style="color: #007bff; text-decoration: none;">gjqmaoslwj@naver.com</a>으로 문의해 주세요.</p>
</footer>


    <script>
        // 페이지 로드 후 지도를 표시합니다.
        function initMap() {
            var map = new naver.maps.Map('map', {
                center: new naver.maps.LatLng(37.5665, 126.9780), // 기본 서울의 좌표 (위도, 경도)
                zoom: 10
            });

            // 지도에 마커 추가 (예시로 서울 시청에 마커 추가)
            var marker = new naver.maps.Marker({
                position: new naver.maps.LatLng(37.5665, 126.9780), // 서울 시청 위치
                map: map
            });

            // 검색된 정비소의 위치를 지도에 표시
            <?php if (!empty($repair_shops)): ?>
                <?php foreach ($repair_shops as $shop): ?>
                    var shopMarker = new naver.maps.Marker({
                        position: new naver.maps.LatLng(<?= esc($shop['latitude']) ?>, <?= esc($shop['longitude']) ?>),
                        map: map,
                        title: "<?= esc($shop['repair_shop_name']) ?>"
                    });
                <?php endforeach; ?>
            <?php endif; ?>
        }

        // 네이버 맵 API 로드 후 initMap 호출
        naver.maps.onJSContentLoaded = initMap;
    </script>
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
