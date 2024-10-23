<?php

namespace App\Models;

use CodeIgniter\Model;

class AutomobileRepairShopModel extends Model
{
    protected $table = 'automobile_repair_shop';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'repair_shop_name', 'repair_shop_type', 'road_address', 'land_lot_address', 'latitude', 'longitude', 
        'registration_date', 'area', 'business_status', 'closure_date', 'break_start_date', 'break_end_date', 
        'operation_start_time', 'operation_end_time', 'phone_number', 'management_agency_name', 
        'management_agency_phone', 'data_reference_date', 'provider_code', 'provider_name'
    ];

    // 1km 이내의 다른 정비소를 찾기 위한 함수
    public function getNearbyRepairShops($latitude, $longitude, $radius = 1)
    {
        // 1km 이내의 정비소를 찾기 위한 SQL 쿼리 작성
        $sql = "
            SELECT *,
                   (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance
            FROM automobile_repair_shop
            HAVING distance < $radius
            ORDER BY distance
        ";

        // SQL 쿼리 실행
        $query = $this->db->query($sql);
        
        // 결과 반환
        return $query->getResultArray();
    }

    // chunk 메소드 재정의
    public function chunk(int $size, \Closure $callback)
    {
        return parent::chunk($size, $callback);
    }

    // 사이트맵용 데이터 가져오기
    public function getSitemapData()
    {
        return $this->findAll(); // 모든 정비소 데이터 반환
    }
}
