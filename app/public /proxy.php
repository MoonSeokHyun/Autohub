<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// API 키와 URL 설정
$apiKey = 'F241011351';  // 실제 API 키
$latitude = $_GET['latitude'];  // 클라이언트에서 보낸 위도
$longitude = $_GET['longitude'];  // 클라이언트에서 보낸 경도
$radius = 1;  // 반경

// 실제 API URL 생성
$url = "http://www.opinet.co.kr/api/aroundAll.do?code=$apiKey&out=json&x=$longitude&y=$latitude&radius=$radius&prodcd=B027&sort=2";

// cURL을 사용하여 외부 API 호출
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// 응답을 그대로 반환
echo $response;
?>
