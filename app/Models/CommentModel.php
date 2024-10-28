<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['parking_lot_id', 'rating', 'comment_text', 'created_at'];

    // 특정 주차장의 모든 댓글 가져오기
    public function getCommentsByParkingLot($parkingLotId)
    {
        return $this->where('parking_lot_id', $parkingLotId)->orderBy('created_at', 'DESC')->findAll();
    }

    // 평점 평균 계산
    public function getAverageRating($parkingLotId)
    {
        return $this->where('parking_lot_id', $parkingLotId)->selectAvg('rating')->get()->getRow()->rating;
    }
}
