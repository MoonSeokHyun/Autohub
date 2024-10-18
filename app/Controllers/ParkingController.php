<?php

namespace App\Controllers;

use App\Models\ParkingLotModel;

class ParkingController extends BaseController
{
    public function index()
    {
        $model = new ParkingLotModel();

        // 페이지네이션 설정
        $perPage = 10; // 한 페이지에 보여줄 주차장 수
        $data['parkingLots'] = $model->paginate($perPage); // 페이지네이션 사용
        $data['pager'] = $model->pager;

        // 뷰에 데이터 전달
        return view('parking/index', $data);
    }

    public function search()
    {
        $searchTerm = $this->request->getVar('search'); // 쿼리에서 검색어 가져오기
        $model = new ParkingLotModel();

        // 검색어가 있는 경우 페이지네이션 사용하여 검색
        $perPage = 10; // 한 페이지에 보여줄 주차장 수
        $data['parkingLots'] = $model
            ->like('name', $searchTerm)
            ->orLike('address_road', $searchTerm)
            ->paginate($perPage); // 검색 결과에 페이지네이션 사용

        $data['pager'] = $model->pager; // 페이지네이션 객체 설정

        return view('parking/index', $data); // 같은 뷰를 재사용
    }

    public function detail($id)
    {
        $parkingLotModel = new ParkingLotModel();
        
        // 주차장 상세 정보 가져오기
        $parkingLot = $parkingLotModel->find($id);
        
        // 주변 주차장 정보 가져오기
        $nearbyParkingLots = $this->getNearbyParkingLots($parkingLot['latitude'], $parkingLot['longitude']);
        
        // 뷰에 데이터 전달
        return view('parking/detail', [
            'parkingLot' => $parkingLot,
            'nearbyParkingLots' => $nearbyParkingLots,
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
}
