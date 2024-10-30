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

    // 주유소 이름을 포함한 최신 리뷰 가져오기
    public function getRecentReviewsWithStationName($limit = 5)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('gas_station_reviews');

        $builder->select('gas_station_reviews.*, gas_station_info.gas_station_name');
        $builder->join('gas_station_info', 'gas_station_reviews.station_id = gas_station_info.id', 'left');
        $builder->orderBy('gas_station_reviews.created_at', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }
}
