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

    // chunk 메소드 재정의
    public function chunk(int $size, \Closure $callback)
    {
        return parent::chunk($size, $callback);
    }

    // 사이트맵용 데이터 가져오기
    public function getSitemapData()
    {
        return $this->findAll(); // 모든 주유소 데이터 반환
    }

    public function getAverageRating($stationId)
    {
        // 평점 데이터를 저장하는 테이블의 이름이 'gas_station_reviews'라고 가정
        $db = \Config\Database::connect();
        $builder = $db->table('gas_station_reviews');
        $builder->selectAvg('rating', 'average_rating');
        $builder->where('station_id', $stationId);

        $result = $builder->get()->getRow();
        return $result ? $result->average_rating : null;
    }

        // 최신 주유소 5개 가져오기 (id 역순)
        public function getRecentGasStations($limit = 5)
        {
            return $this->orderBy('id', 'DESC')->findAll($limit);
        }
        public function getPopularGasStations()
        {
            $db = \Config\Database::connect();
            $builder = $db->table('gas_station_info');
        
            $builder->select('gas_station_info.id, gas_station_info.gas_station_name, gas_station_info.road_address, COUNT(gas_station_reviews.id) as review_count, AVG(gas_station_reviews.rating) as average_rating');
            $builder->join('gas_station_reviews', 'gas_station_info.id = gas_station_reviews.station_id', 'left');
            $builder->groupBy('gas_station_info.id');
            $builder->orderBy('review_count', 'DESC');
            $builder->limit(5); // 원하는 인기 주유소 개수 설정
        
            return $builder->get()->getResultArray();
        }


}