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
}
