<?php

namespace App\Controllers;

use App\Models\ChargingStationModel;
use CodeIgniter\Controller;

class ChargingStationController extends Controller
{
    public function fetchAndSave()
    {
        $model = new ChargingStationModel();
        $totalFetched = 0;
        $page = 1;
        
        do {
            // API에서 데이터를 가져오기
            $chargingStations = $model->fetchAllChargingStations($page);
            // 가져온 데이터를 DB에 저장
            $model->saveChargingStations($chargingStations);
            $totalFetched += count($chargingStations);
            echo "페이지 {$page}에서 {$totalFetched}개 데이터 획득.\n"; // 서버 콘솔에 데이터 획득 메시지 출력
            $page++;
            sleep(10); // 10초 대기
        } while (count($chargingStations) > 0); // 더 이상 데이터가 없을 때까지 반복

        return redirect()->to('/charging-stations'); // 완료 후 목록 페이지로 이동
    }

    public function index()
    {
        $model = new ChargingStationModel();
        $data['chargingStations'] = $model->getAllChargingStations(); // 모든 충전소 데이터 가져오기
        return view('charging_stations/index', $data); // 목록 페이지로 데이터 전달
    }
}
