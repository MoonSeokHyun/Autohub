<?php

namespace App\Controllers;

use App\Models\ParkingLotModel;
use App\Models\CommentModel; // 댓글 모델 추가

class ParkingController extends BaseController
{
    public function index()
    {
        $model = new ParkingLotModel();
        $commentModel = new CommentModel();

        // 페이지네이션 설정
        $perPage = 5;
        $data['parkingLots'] = $model->paginate($perPage);
        $data['pager'] = $model->pager;

        // 최근 추가된 주차장 가져오기
        $data['recentParkingLots'] = $model->select('id, name, address_road')->orderBy('id', 'DESC')->limit(5)->findAll() ?? [];

        // 인기 주차장 (평균 별점 기준)
        $data['popularParkingLots'] = $commentModel->select('parking_lot.id, parking_lot.name, COUNT(comments.id) AS review_count, AVG(comments.rating) AS average_rating')
            ->join('parking_lot', 'comments.parking_lot_id = parking_lot.id')
            ->groupBy('comments.parking_lot_id')
            ->orderBy('average_rating', 'DESC')
            ->limit(5)
            ->findAll() ?? [];

        // 최근 추가된 리뷰 가져오기
        $data['recentReviews'] = $commentModel->select('comments.comment_text, comments.created_at, comments.rating, parking_lot.id AS parking_lot_id, parking_lot.name AS parking_lot_name')
            ->join('parking_lot', 'comments.parking_lot_id = parking_lot.id')
            ->orderBy('comments.created_at', 'DESC')
            ->limit(5)
            ->findAll() ?? [];

        // 1km 이내 주차장 가져오기
        $centerLat = 37.5665;
        $centerLng = 126.9780;
        $data['nearbyParkingLots'] = $model->select("id, name, latitude, longitude, (6371 * acos(cos(radians($centerLat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($centerLng)) + sin(radians($centerLat)) * sin(radians(latitude)))) AS distance")
            ->having('distance <=', 1) // 1km 이내
            ->orderBy('distance', 'ASC')
            ->limit(20)
            ->findAll() ?? [];

        return view('parking/index', $data);
    }

    public function detail($id)
    {
        $parkingLotModel = new ParkingLotModel();
        $commentModel = new CommentModel();
    
        // 주차장 상세 정보 가져오기
        $parkingLot = $parkingLotModel->find($id);
    
        // 주차장 정보 유효성 확인 및 가상의 위치 정보 할당
        if (!$parkingLot) {
            // 기본 가상의 주차장 데이터 설정
            $parkingLot = [
                'id' => $id,
                'name' => '가상의 주차장',
                'latitude' => 37.5665, // 서울 시청 근처 위도
                'longitude' => 126.9780, // 서울 시청 근처 경도
                // 필요한 추가 정보도 여기에 채워줄 수 있습니다.
            ];
        } else {
            // 위도와 경도가 없는 경우 가상의 위치 할당
            if (!isset($parkingLot['latitude']) || !isset($parkingLot['longitude'])) {
                $parkingLot['latitude'] = 37.5665;
                $parkingLot['longitude'] = 126.9780;
            }
        }
    
        // 주변 주차장 정보 가져오기
        $nearbyParkingLots = $this->getNearbyParkingLots($parkingLot['latitude'], $parkingLot['longitude']);
    
        // 댓글과 평점 가져오기
        $comments = $commentModel->getCommentsByParkingLot($id);
        $averageRating = $commentModel->getAverageRating($id);
    
        // 뷰에 데이터 전달
        return view('parking/detail', [
            'parkingLot' => $parkingLot,
            'nearbyParkingLots' => $nearbyParkingLots,
            'comments' => $comments,
            'averageRating' => $averageRating,
        ]);
    }

    private function getNearbyParkingLots($latitude, $longitude)
    {
        $parkingLotModel = new ParkingLotModel();

        // Haversine 공식을 사용한 SQL 쿼리로 3km 이내의 주차장 가져오기
        $nearbyParkingLots = $parkingLotModel
            ->select("*, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
            ->having("distance <= 3") // 3km 이내
            ->orderBy('distance', 'ASC') // 거리 기준으로 정렬
            ->findAll(5); // 최대 5개 주변 주차장 가져오기

        return $nearbyParkingLots; // 주변 주차장 리스트 반환
    }

    // 댓글 저장 메서드
    public function saveComment()
    {
        $commentModel = new CommentModel();

        $data = [
            'parking_lot_id' => $this->request->getPost('parking_lot_id'),
            'rating' => $this->request->getPost('rating'),
            'comment_text' => $this->request->getPost('comment_text')
        ];

        $commentModel->save($data);
        return redirect()->back()->with('message', '댓글이 등록되었습니다.');
    }
}
