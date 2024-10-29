<?php

namespace App\Models;

use CodeIgniter\Model;

class AutomobileRepairShopReviewModel extends Model
{
    protected $table = 'automobile_repair_shop_reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = ['repair_shop_id', 'rating', 'comment_text'];

    // 특정 정비소의 리뷰 평균 평점 계산
    public function getAverageRating($repairShopId)
    {
        $this->selectAvg('rating');
        $this->where('repair_shop_id', $repairShopId);
        $result = $this->get()->getRow();
        return $result ? $result->rating : 0;
    }

    // 정비소별 리뷰 점수 합계 계산 (정비소 이름 포함)
    public function getPopularRepairShops()
    {
        return $this->select('automobile_repair_shop.repair_shop_name, repair_shop_id, SUM(rating) as total_rating')
                    ->join('automobile_repair_shop', 'automobile_repair_shop.id = automobile_repair_shop_reviews.repair_shop_id')
                    ->groupBy('repair_shop_id')
                    ->orderBy('total_rating', 'DESC')
                    ->findAll(5); // 상위 5개 정비소만 가져옴
    }
}
