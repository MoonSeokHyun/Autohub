<?php

namespace App\Models;

use CodeIgniter\Model;

class AutomobileRepairShopReviewModel extends Model
{
    protected $table = 'automobile_repair_shop_reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = ['repair_shop_id', 'rating', 'comment_text', 'created_at'];

    // 특정 정비소의 리뷰 평균 평점 계산
    public function getAverageRating($repairShopId)
    {
        $this->selectAvg('rating');
        $this->where('repair_shop_id', $repairShopId);
        $result = $this->get()->getRow();
        return $result ? $result->rating : 0;
    }
}
