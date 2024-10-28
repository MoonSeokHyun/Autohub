<?php

namespace App\Models;

use CodeIgniter\Model;

class GasStationReviewModel extends Model
{
    protected $table = 'gas_station_reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = ['station_id', 'rating', 'comment_text', 'created_at'];

    // 특정 주유소의 모든 리뷰 가져오기
    public function getReviewsByStationId($stationId)
    {
        return $this->where('station_id', $stationId)->findAll();
    }
}
