<?php

namespace App\Models;

use CodeIgniter\Model;

class ParkingLotModel extends Model
{
    protected $table = 'parking_lot'; // 데이터베이스 테이블 이름
    protected $primaryKey = 'id'; // 기본 키
    protected $allowedFields = [
        'management_number',
        'name',
        'type',
        'category',
        'address_road',
        'address_land',
        'total_spots',
        'grade',
        'sub_execution',
        'operating_days',
        'weekday_start_time',
        'weekday_end_time',
        'saturday_start_time',
        'saturday_end_time',
        'holiday_start_time',
        'holiday_end_time',
        'fee_information',
        'basic_parking_time',
        'basic_fee',
        'additional_unit_time',
        'additional_unit_fee',
        'daily_parking_fee_hours',
        'daily_parking_fee',
        'monthly_pass_fee',
        'payment_method',
        'special_notes',
        'management_agency',
        'phone_number',
        'latitude',
        'longitude',
        'disabled_parking_spots',
        'data_reference_date',
        'provider_code',
        'provider_name'
    ];

    // 페이징 처리된 주차장 목록 가져오기
    public function getParkingLots($perPage = 10)
    {
        return $this->paginate($perPage); // paginate 메서드를 사용하여 페이징 처리된 결과 반환
    }
    
    // 전체 주차장 수 가져오기
    public function getTotalParkingLots()
    {
        return $this->countAll();
    }

    // 사이트맵용 데이터 가져오기
    public function getSitemapData()
    {
        return $this->findAll(); // 모든 주차장 데이터 반환
    }
    
    // 주차장 정보를 Chunk로 처리 (대량 데이터에 유용)
    public function chunk(int $size, \Closure $callback)
    {
        $builder = $this->builder();
        $offset = 0;

        do {
            $builder->limit($size, $offset);
            $results = $builder->get()->getResultArray();

            if (empty($results)) {
                break;
            }

            // 콜백 함수 호출
            $callback($results);

            $offset += $size;
        } while (!empty($results));
    }

    // 데이터 삽입 또는 업데이트 함수 (API 데이터를 비교하여 업데이트)
    public function saveOrUpdate($data)
    {
        // management_number를 기준으로 기존 데이터 검색
        $existing = $this->where('management_number', $data['management_number'])->first();
    
        if ($existing) {
            // 기존 데이터가 있는 경우, 차이가 있는지 확인하고 업데이트
            if ($this->hasChanges($existing, $data)) {
                $this->update($existing['id'], $data);
                return 'updated';
            }
        } else {
            // 기존 데이터가 없는 경우, 새 데이터 삽입
            $this->insert($data);
            return 'inserted';
        }
    
        return 'no_change';
    }
    // 기존 데이터와 새 데이터의 차이가 있는지 확인
    private function hasChanges($existingData, $newData)
    {
        // 비교할 필드 목록
        $fieldsToCheck = [
            'name', 'type', 'category', 'address_road', 'address_land',
            'total_spots', 'grade', 'sub_execution', 'operating_days',
            'weekday_start_time', 'weekday_end_time', 'saturday_start_time', 'saturday_end_time',
            'holiday_start_time', 'holiday_end_time', 'fee_information', 'basic_parking_time',
            'basic_fee', 'additional_unit_time', 'additional_unit_fee', 'daily_parking_fee_hours',
            'daily_parking_fee', 'monthly_pass_fee', 'payment_method', 'special_notes',
            'management_agency', 'phone_number', 'latitude', 'longitude',
            'disabled_parking_spots', 'data_reference_date', 'provider_code', 'provider_name'
        ];

        foreach ($fieldsToCheck as $field) {
            if ($existingData[$field] != $newData[$field]) {
                return true;
            }
        }

        return false;
    }
}
