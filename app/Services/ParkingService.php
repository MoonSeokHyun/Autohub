<?php

namespace App\Services;

use App\Models\ParkingLotModel;

class ParkingService
{
    protected $parkingLotModel;

    public function __construct()
    {
        $this->parkingLotModel = new ParkingLotModel();
    }

    public function updateParkingData()
    {
        // 업데이트와 삽입된 항목 수를 추적하기 위한 변수들
        $updatedCount = 0;
        $insertedCount = 0;

        // API 호출 URL 구성
        $apiUrl = "http://api.data.go.kr/openapi/tn_pubr_prkplce_info_api";
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
                    'management_number' => $item['prkplceNo'],
                    'name' => $item['prkplceNm'],
                    'type' => $item['prkplceSe'],
                    'category' => $item['prkplceType'],
                    'address_road' => $item['rdnmadr'],
                    'address_land' => $item['lnmadr'],
                    'total_spots' => $item['prkcmprt'],
                    'grade' => $item['feedingSe'],
                    'sub_execution' => $item['enforceSe'],
                    'operating_days' => $item['operDay'],
                    'weekday_start_time' => $item['weekdayOperOpenHhmm'],
                    'weekday_end_time' => $item['weekdayOperColseHhmm'],
                    'saturday_start_time' => $item['satOperOperOpenHhmm'],
                    'saturday_end_time' => $item['satOperCloseHhmm'],
                    'holiday_start_time' => $item['holidayOperOpenHhmm'],
                    'holiday_end_time' => $item['holidayCloseHhmm'],
                    'fee_information' => $item['parkingchrgeInfo'],
                    'basic_parking_time' => $item['basicTime'],
                    'basic_fee' => $item['basicCharge'],
                    'additional_unit_time' => $item['addUnitTime'],
                    'additional_unit_fee' => $item['addUnitCharge'],
                    'daily_parking_fee_hours' => $item['dayCmmtktAdjTime'],
                    'daily_parking_fee' => $item['dayCmmtkt'],
                    'monthly_pass_fee' => $item['monthCmmtkt'],
                    'payment_method' => $item['metpay'],
                    'special_notes' => $item['spcmnt'],
                    'management_agency' => $item['institutionNm'],
                    'phone_number' => $item['phoneNumber'],
                    'latitude' => $item['latitude'],
                    'longitude' => $item['longitude'],
                    'disabled_parking_spots' => $item['pwdbsPpkZoneYn'],
                    'data_reference_date' => $item['referenceDate'],
                    'provider_code' => $item['instt_code'],
                    'provider_name' => $item['instt_nm']
                ];

                // 데이터 저장 또는 업데이트 결과 확인
                $result = $this->parkingLotModel->saveOrUpdate($mappedData);

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
