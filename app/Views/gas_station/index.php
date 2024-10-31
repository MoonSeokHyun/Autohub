<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-WVK2PC5J');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Hub - 주유소</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <script src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=psp2wjl0ra"></script>
    <script>
        function goToDetail(id) {
            if (id) {
                window.location.href = '/gas_stations/' + id;
            }
        }

        let map;
        function initMap() {
            const mapOptions = {
                center: new naver.maps.LatLng(37.5665, 126.978),
                zoom: 14,
                scaleControl: true,
                mapTypeControl: true,
                zoomControl: true,
                logoControl: false
            };
            map = new naver.maps.Map('map', mapOptions);

            const nearbyGasStations = [
                { lat: 37.5705, lng: 126.980, name: '주유소 A', address: '서울시 강남구 역삼동 123', phone: '010-1234-5678' },
                { lat: 37.5645, lng: 126.976, name: '주유소 B', address: '서울시 서초구 방배동 456', phone: '010-2345-6789' }
            ];

            nearbyGasStations.forEach(station => {
                new naver.maps.Marker({
                    position: new naver.maps.LatLng(station.lat, station.lng),
                    map: map,
                    title: station.name
                });
            });
        }
        document.addEventListener("DOMContentLoaded", initMap);
    </script>
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
            <form action="<?= base_url('gas_stations/search'); ?>" method="get">
                <input type="text" name="search" placeholder="주유소 이름 검색..." required>
                <button type="submit">검색</button>
            </form>
        </div>

        <!-- 지도 -->
        <div id="map"></div>

        <!-- 최근 추가된 주유소 섹션 -->
        <section>
            <h2>최근 추가된 주유소</h2>
            <div class="recent-slides">
                <?php foreach ($recentGasStations as $station): ?>
                    <div class="recent-slide card" onclick="goToDetail(<?= $station['id']; ?>)">
                        <h3><?= esc($station['gas_station_name']); ?></h3>
                        <p><?= esc($station['road_address']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- 인기 주유소 섹션 -->
        <section>
            <h2>인기 주유소</h2>
            <table>
                <thead>
                    <tr>
                        <th>주유소 이름</th>
                        <th>주소</th>
                        <th>리뷰 개수</th>
                        <th>평균 평점</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($popularGasStations as $station): ?>
                        <tr class="clickable-row" onclick="goToDetail(<?= $station['id']; ?>)">
                            <td><?= esc($station['gas_station_name']); ?></td>
                            <td><?= esc($station['road_address']); ?></td>
                            <td><?= esc($station['review_count']); ?></td>
                            <td><?= number_format($station['average_rating'], 1); ?> 점</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- 최근 리뷰 섹션 -->
        <section class="reviews">
            <h2>최근 리뷰</h2>
            <?php foreach ($recentReviews as $review): ?>
                <div class="review-card" onclick="goToDetail(<?= isset($review['gas_station_id']) ? esc($review['gas_station_id']) : '0'; ?>)">
                    <div class="review-title"><?= isset($review['gas_station_name']) ? esc($review['gas_station_name']) : '정보 없음'; ?> - 
                        <span class="review-rating"><?= isset($review['rating']) ? esc($review['rating']) : '0'; ?>점</span>
                    </div>
                    <div class="review-text"><?= isset($review['comment_text']) ? esc($review['comment_text']) : '리뷰 없음'; ?></div>
                    <small>작성일: <?= isset($review['created_at']) ? date('Y-m-d', strtotime($review['created_at'])) : '알 수 없음'; ?></small>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- 주유소 목록 섹션 -->
        <section>
            <h2>주유소 목록</h2>
            <table>
                <thead>
                    <tr>
                        <th>주유소 이름</th>
                        <th>주소</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gasStations as $station): ?>
                        <tr class="clickable-row" onclick="goToDetail(<?= $station['id']; ?>)">
                            <td><?= esc($station['gas_station_name']); ?></td>
                            <td><?= esc($station['road_address']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- 페이지네이션 -->
        <div class="pager">
            <?= $pager->links('gasStationsGroup', 'default_full') ?>
        </div>
    </div>

    <!-- 풀 화면 푸터 -->
    <footer style="background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #6c757d;">
        <p>본 데이터는 <a href="https://www.data.go.kr" target="_blank" style="color: #007bff; text-decoration: none;">www.data.go.kr</a>에서 데이터 기반으로 만들어진 웹 사이트입니다.</p>
        <p>이 웹 사이트는 영리 목적으로 만들어진 사이트입니다.</p>
        <p>잘못된 정보는 <a href="mailto:gjqmaoslwj@naver.com" style="color: #007bff; text-decoration: none;">gjqmaoslwj@naver.com</a>으로 문의해 주세요.</p>
    </footer>
    	
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
