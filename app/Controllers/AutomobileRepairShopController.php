<?php

namespace App\Controllers;

use App\Models\AutomobileRepairShopModel;

class AutomobileRepairShopController extends BaseController
{
    public function index()
    {
        $model = new AutomobileRepairShopModel();
    
        // 페이지네이션 설정
        $pager = \Config\Services::pager();
        $perPage = 10; // 한 페이지에 보여줄 항목 수
    
        // 검색어가 있으면 검색 필터링
        $search = $this->request->getGet('search');
        if ($search) {
            // 'repair_shop_name'과 'road_address' 필드를 검색하도록 수정
            $repair_shops = $model->like('repair_shop_name', $search)
                                  ->orLike('road_address', $search)
                                  ->paginate($perPage);
        } else {
            // 검색어가 없으면 모든 데이터를 출력
            $repair_shops = $model->paginate($perPage);
        }
    
        // 뷰로 전달할 데이터
        return view('automobile_repair_shop/index', [
            'repair_shops' => $repair_shops,
            'pager' => $pager,  // 페이지네이션 객체 전달
            'search' => $search  // 검색어 전달
        ]);
    }

    public function detail($id)
    {
        $model = new AutomobileRepairShopModel();
        
        // 특정 정비소 데이터 가져오기 (find() 사용)
        $repair_shop = $model->find($id);

        // 정비소가 없으면 404 페이지 표시
        if (!$repair_shop) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('정비소를 찾을 수 없습니다.');
        }

        // 1km 이내의 다른 정비소를 찾기 위한 거리 계산
        $nearby_shops = $model->getNearbyRepairShops($repair_shop['latitude'], $repair_shop['longitude'], 1);

        // 디테일 뷰로 데이터 전달
        return view('automobile_repair_shop/detail', [
            'repair_shop' => $repair_shop,
            'nearby_shops' => $nearby_shops
        ]);
    }
}
