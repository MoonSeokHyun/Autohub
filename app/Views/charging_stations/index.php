<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>충전소 목록</title>
</head>
<body>
    <h1>충전소 목록</h1>

    <button id="fetchButton">충전소 데이터 요청</button>
    
    <div id="message"></div>

    <?php if (isset($chargingStations) && !empty($chargingStations)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>충전소 이름</th>
                    <th>주소</th>
                    <th>위도</th>
                    <th>경도</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chargingStations as $station): ?>
                    <tr>
                        <td><?= isset($station['station_name']) ? esc($station['station_name']) : '정보 없음' ?></td>
                        <td><?= isset($station['station_address']) ? esc($station['station_address']) : '정보 없음' ?></td>
                        <td><?= isset($station['latitude']) ? esc($station['latitude']) : '정보 없음' ?></td>
                        <td><?= isset($station['longitude']) ? esc($station['longitude']) : '정보 없음' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>충전소 정보가 없습니다.</p>
    <?php endif; ?>

    <script>
        document.getElementById('fetchButton').addEventListener('click', function() {
            const messageDiv = document.getElementById('message');
            messageDiv.innerHTML = '데이터 요청 중...';
            
            fetch('charging_stations/fetch')
                .then(response => response.text())
                .then(data => {
                    messageDiv.innerHTML = data;
                    location.reload(); // 새로 고침하여 데이터 업데이트
                })
                .catch(error => {
                    messageDiv.innerHTML = '데이터 요청 실패: ' + error;
                });
        });
    </script>
</body>
</html>
