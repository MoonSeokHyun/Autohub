<?php

namespace App\Services;

use App\Models\GasStationModel;

class GasStationService
{
    protected $gasStationModel;

    public function __construct()
    {
        $this->gasStationModel = new GasStationModel();
    }

    public function updateGasStationData()
    {
        // 업데이트와 삽입된 항목 수를 추적하기 위한 변수들
        $updatedCount = 0;
        $insertedCount = 0;

        // API 호출 URL 구성
        $apiUrl = "http://api.data.go.kr/openapi/tn_pubr_gasstation_info_api";
        $apiKey = "laaaH4%2Bnm2VrDZAve3%2B7kNvJitTpHwJWPA38HpR69%2BNeba1ZiPpPyb8mxneuCSZSeVo0nuySuUSuLjCNLSPAiw%3D%3D";
        $params = [
            'serviceKey' => $apiKey,
            'type' => 'json',
            'pageNo' => 1,
            'numOfRows' => 100
        ];

        $url = $apiUrl . '?' . http_build_query($params);

        // cURL을 사용하여 API 호출
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $mappedData = [
                    'gas_station_name' => $item['CONM_NM'],
                    'city_name' => $item['CTPV_NM'],
                    'district_name' => $item['SGG_NM'],
                    'road_address' => $item['LCTN_ROAD_NM'],
                    'lot_address' => $item['LCTN_LOTNO_ADDR'],
                    'phone_number' => $item['TELNO'],
                    'latitude' => $item['LAT'],
                    'longitude' => $item['LOT'],
                    'brand_name' => $item['TDMK_SE_NM'],
                    'representative_name' => $item['RPRSV_NM'],
                    'total_staff' => $item['TNOEMP'],
                    'data_reference_date' => $item['DATA_CRTR_YMD'],
                    'providing_agency_code' => $item['instt_code'],
                    'providing_agency_name' => $item['instt_nm']
                ];

                // 데이터 저장 또는 업데이트 결과 확인
                $result = $this->gasStationModel->saveOrUpdate($mappedData);

                if ($result === 'updated') {
                    $updatedCount++;
                } elseif ($result === 'inserted') {
                    $insertedCount++;
                }
            }
        }

        return [
            'updated' => $updatedCount,
            'inserted' => $insertedCount
        ];
    }
}
