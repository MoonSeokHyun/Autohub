<?php

namespace App\Models;

use CodeIgniter\Model;

class ChargingStationModel extends Model
{
    protected $table = 'charging_stations'; // 데이터베이스 테이블 이름
    protected $allowedFields = ['station_name', 'station_address', 'latitude', 'longitude']; // 저장할 필드

    public function fetchAllChargingStations($page = 1, $perPage = 10)
    {
        $serviceKey = 'laaaH4+nm2VrDZAve3+7kNvJitTpHwJWPA38HpR69+Neba1ZiPpPyb8mxneuCSZSeVo0nuySuUSuLjCNLSPAiw==';
        // URL에서 &를 사용하여 쿼리 문자열을 구성
        $url = "https://api.odcloud.kr/api/EvInfoServiceV2/v1/getEvSearchList?serviceKey={$serviceKey}&page={$page}&perPage={$perPage}";

        $response = @file_get_contents($url);
        if ($response === false) {
            throw new \RuntimeException("API 호출 실패: " . error_get_last()['message']);
        }

        $data = json_decode($response, true);
        return isset($data['data']) ? $data['data'] : [];
    }

    public function saveChargingStations(array $chargingStations)
    {
        foreach ($chargingStations as $station) {
            // 중복 체크
            $existing = $this->where('station_name', $station['station_name'])->first();
            if (!$existing) {
                $this->insert($station);
            }
        }
    }

    public function getAllChargingStations()
    {
        return $this->findAll();
    }
}
