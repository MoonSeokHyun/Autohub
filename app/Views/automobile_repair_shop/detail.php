<?php
// 예시로 정비소의 도로명 주소
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
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
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
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "AutoRepair",
      "name": "<?= esc($repair_shop['repair_shop_name']); ?>",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?= esc($repair_shop['road_address']); ?>",
        "addressLocality": "<?= esc($district_name); ?>",
        "addressCountry": "KR"
      },
      "telephone": "<?= esc($repair_shop['phone_number']); ?>",
      "openingHours": "<?= esc($repair_shop['operation_start_time']); ?>-<?= esc($repair_shop['operation_end_time']); ?>",
      "image": "이미지 URL",
      "url": "페이지 URL"
    }
    </script>
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
                    <td><?= esc($repair_shop['repair_shop_type']); ?></td>
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
                    <td><?= esc($repair_shop['business_status']); ?></td>
                </tr>
                <tr>
                    <th>휴무일</th>
                    <td><?= esc($repair_shop['closure_date']); ?></td>
                </tr>
                <tr>
                    <th>점심시간</th>
                    <td><?= esc($repair_shop['break_start_date']); ?> ~ <?= esc($repair_shop['break_end_date']); ?></td>
                </tr>
                <tr>
                    <th>영업시간</th>
                    <td><?= esc($repair_shop['operation_start_time']); ?> ~ <?= esc($repair_shop['operation_end_time']); ?></td>
                </tr>
                <tr>
                    <th>관리기관명</th>
                    <td><?= esc($repair_shop['management_agency_name']); ?></td>
                </tr>
                <tr>
                    <th>관리기관 전화번호</th>
                    <td><?= esc($repair_shop['management_agency_phone']); ?></td>
                </tr>
                <tr>
                    <th>데이터 기준 날짜</th>
                    <td><?= esc($repair_shop['data_reference_date']); ?></td>
                </tr>
                <tr>
                    <th>제공업체 코드</th>
                    <td><?= esc($repair_shop['provider_code']); ?></td>
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
            if (empty($nearby_shops)) {
                echo "<tr><td colspan='4'>근처 정비소 정보가 없습니다.</td></tr>";
            } else {
                $nearby_shops = array_slice($nearby_shops, 0, 8);
                foreach ($nearby_shops as $shop): 
                    // 거리 값이 0.00022같은 소수점 많은 값을 받아서 소수 첫째 자리까지 반올림
                    $distance = round($shop['distance'], 1);
                    ?>
                    <tr class="table-row" onclick="window.location.href='/automobile_repair_shop/<?= esc($shop['id']) ?>'">
                        <td><?= esc($shop['repair_shop_name']); ?></td>
                        <td><?= esc($shop['road_address']); ?></td>
                        <td><?= esc($shop['phone_number']); ?></td>
                        <td><?= $distance; ?> km</td>
                    </tr>
                <?php endforeach; ?>
            <?php } ?>
        </tbody>
    </table>
</div>
    </div>

    <script>
        // 지도 초기화 코드
        var map = new naver.maps.Map('map', {
            center: new naver.maps.LatLng(<?= esc($repair_shop['latitude']); ?>, <?= esc($repair_shop['longitude']); ?>),
            zoom: 16
        });
        var marker = new naver.maps.Marker({
            position: new naver.maps.LatLng(<?= esc($repair_shop['latitude']); ?>, <?= esc($repair_shop['longitude']); ?>),
            map: map
        });
    </script>
</body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WVK2PC5J"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</html>
