<?php
namespace App\Models;

use CodeIgniter\Model;

class GasStationModel extends Model
{
    protected $table = 'gas_station_info';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'gas_station_name', 
        'city_name', 
        'district_name', 
        'road_address', 
        'lot_address', 
        'phone_number', 
        'latitude', 
        'longitude', 
        'brand_name', 
        'representative_name', 
        'total_staff', 
        'data_reference_date', 
        'providing_agency_code', 
        'providing_agency_name', 
        'station_code'
    ];

    // Haversine formula를 이용한 거리 계산
    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // 지구 반지름 (단위: km)
        
        // 도를 라디안으로 변환
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
        
        // 위도, 경도의 차이
        $latDiff = $lat2 - $lat1;
        $lonDiff = $lon2 - $lon1;
        
        // Haversine 공식을 이용한 거리 계산
        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos($lat1) * cos($lat2) *
             sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        // 거리 반환 (단위: km)
        return $earthRadius * $c;
    }

    // 주유소 ID로 정보 가져오기
    public function getGasStation($id)
    {
        return $this->find($id);
    }

    // 주어진 좌표로 가까운 주유소 찾기
    public function getNearbyGasStations($latitude, $longitude, $radius = 3, $limit = 5)
    {
        $gasStations = $this->findAll();
        $nearbyGasStations = [];

        // 각 주유소의 거리 계산 후 리스트에 추가
        foreach ($gasStations as $station) {
            $distance = $this->haversineDistance($latitude, $longitude, $station['latitude'], $station['longitude']);
            if ($distance <= $radius) {
                $nearbyGasStations[] = array_merge($station, ['distance' => $distance]);
            }
        }

        // 거리 기준 오름차순 정렬
        usort($nearbyGasStations, function($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });

        // 결과 제한 (기본값: 5개)
        return array_slice($nearbyGasStations, 0, $limit);
    }

    // OPINET API를 사용해 주유소 유가 정보 가져오기
    public function getFuelPrices($stationCode)
    {
        $apiUrl = 'http://www.opinet.co.kr/api/price.do';
        $apiKey = 'F241011351'; // 실제 API 키
        $params = [
            'out' => 'json',
            'stationName' => $stationCode,
            'key' => $apiKey
        ];
        
        $queryString = http_build_query($params);
        $url = $apiUrl . '?' . $queryString;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            return ['error' => 'API 요청 실패'];
        }

        curl_close($ch);
        $data = json_decode($response, true);

        if (isset($data['RESULT'])) {
            return [
                'gasoline' => $data['RESULT']['OIL'][0]['PRICE'],
                'diesel' => $data['RESULT']['OIL'][1]['PRICE'],
                'kerosene' => $data['RESULT']['OIL'][2]['PRICE']
            ];
        } else {
            return ['error' => '유가 데이터를 찾을 수 없습니다.'];
        }
    }

    // 최저가 주유소 TOP10 정보 가져오기
    public function get_lowest_price_stations($prodcd, $area = '', $cnt = 10)
    {
        $url = 'http://www.opinet.co.kr/api/lowTop10.do';
        $apiKey = 'F241011351'; // 실제 API 키
        $params = [
            'code' => $apiKey,
            'out' => 'json',
            'prodcd' => $prodcd,
            'area' => $area,
            'cnt' => $cnt
        ];

        // API 호출
        $response = $this->call_api($url, $params);

        // 결과 반환
        if ($response && isset($response['RESULT']) && $response['RESULT'] == 'SUCCESS') {
            return $response['OPINET']['RESULT'];
        }

        return null;
    }

    // API 호출 함수
    private function call_api($url, $params)
    {
        $queryString = http_build_query($params);
        $url = $url . '?' . $queryString;

        // cURL로 API 호출
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // SSL 인증서 오류 방지
        $response = curl_exec($ch);
        curl_close($ch);

        // JSON 응답을 배열로 반환
        return json_decode($response, true);
    }

    // 가장 가까운 주유소 코드 찾기
    public function getStationCodeByLocation($latitude, $longitude)
    {
        $stations = $this->findAll();
        $closestStation = null;
        $minDistance = PHP_INT_MAX;

        foreach ($stations as $station) {
            $distance = $this->haversineDistance($latitude, $longitude, $station['latitude'], $station['longitude']);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $closestStation = $station;
            }
        }

        if ($closestStation) {
            return $closestStation['station_code'];
        } else {
            return ['error' => '주유소를 찾을 수 없습니다.'];
        }
    }

    // 주유소 목록 가져오기 (검색, 페이지네이션 포함)
    public function getGasStations($limit = 10, $page = 1, $search = null)
    {
        if ($search) {
            // 검색어가 있을 경우 이름과 주소로 LIKE 검색
            return $this->like('gas_station_name', $search)
                        ->orLike('road_address', $search)
                        ->paginate($limit, 'gasStationsGroup');
        }
    
        // 검색어가 없으면 모든 주유소 반환
        return $this->paginate($limit, 'gasStationsGroup');
    }
}
?>
