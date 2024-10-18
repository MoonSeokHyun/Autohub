<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($chargingStation['csNm']) ?> 상세 정보</title>
</head>
<body>
    <h1><?= esc($chargingStation['csNm']) ?> 상세 정보</h1>
    <p>주소: <?= esc($chargingStation['addr']) ?></p>
    <p>위도: <?= esc($chargingStation['lat']) ?></p>
    <p>경도: <?= esc($chargingStation['longi']) ?></p>
    <p>충전기 타입: <?= esc($chargingStation['chargeTp']) ?></p>
    <p>상태: <?= esc($chargingStation['cpStat']) ?></p>
</body>
</html>
