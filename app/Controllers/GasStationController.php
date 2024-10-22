<?php
namespace App\Controllers;

use App\Models\GasStationModel;

class GasStationController extends BaseController
{
    protected $gasStationModel;

    public function __construct()
    {
        $this->gasStationModel = new GasStationModel();
    }

    public function index()
    {
        // 모델에서 페이징 처리된 주유소 목록 가져오기 (예: 페이지당 10개)
        $page = $this->request->getVar('page') ?? 1;
        $data['gasStations'] = $this->gasStationModel->paginate(10, 'gasStationsGroup');
        
        // Pagination 링크 설정
        $data['pager'] = $this->gasStationModel->pager;
    
        return view('gas_station/index', $data);
    }

    public function search()
{
    $searchQuery = $this->request->getGet('search');

    // 검색어가 없을 때 빈 결과 반환
    if (!$searchQuery) {
        return redirect()->to('/gas_stations');
    }

    // 검색어를 통해 주유소 목록 검색
    $data['gasStations'] = $this->gasStationModel->getGasStations(10, 1, $searchQuery);

    // 검색 결과가 없으면 메시지 설정
    if (empty($data['gasStations'])) {
        $data['noResultsMessage'] = '검색 결과가 없습니다.';
    }

    // Pagination 링크 설정
    $data['pager'] = $this->gasStationModel->pager;

    return view('gas_station/index', $data);
}

    // 주유소 상세 페이지
    public function detail($stationId)
    {
        // 주유소 정보 가져오기
        $station = $this->gasStationModel->getGasStation($stationId);

        // 주유소 좌표를 기준으로 3km 내의 다른 주유소 정보 가져오기
        $nearbyGasStations = $this->gasStationModel->getNearbyGasStations($station['latitude'], $station['longitude']);

        // 주유소 코드 가져오기
        $stationCode = $station['station_code'];

        // 지도에 마커 표시 및 유가 정보 출력
        return view('gas_station/detail', [
            'station' => $station,
            'nearbyGasStations' => $nearbyGasStations,
        ]);
    }
}
