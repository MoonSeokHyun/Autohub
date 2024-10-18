<?php

namespace App\Controllers;

use App\Models\ParkingLotModel;

class TestController extends BaseController
{
    protected $parkingLotModel;

    public function __construct()
    {
        $this->parkingLotModel = new ParkingLotModel(); // 모델 인스턴스 생성
    }

    // 모든 주차장 목록을 가져오는 테스트 메서드
    public function index()
    {
        $parkingLots = $this->parkingLotModel->findAll(); // 모든 주차장 정보 가져오기

        return view('parking_list', ['parkingLots' => $parkingLots]); // parking_list 뷰로 데이터 전달
    }
}
