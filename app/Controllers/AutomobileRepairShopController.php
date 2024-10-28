<?php

namespace App\Controllers;

use App\Models\AutomobileRepairShopModel;
use App\Models\AutomobileRepairShopReviewModel;
use CodeIgniter\Controller;

class AutomobileRepairShopController extends BaseController
{
    protected $repairShopModel;
    protected $reviewModel;

    public function __construct()
    {
        $this->repairShopModel = new AutomobileRepairShopModel();
        $this->reviewModel = new AutomobileRepairShopReviewModel();
    }

    public function index()
    {
        // 페이지네이션 설정
        $pager = \Config\Services::pager();
        $perPage = 10; // 한 페이지에 보여줄 항목 수

        // 검색어가 있는 경우 필터링
        $search = $this->request->getGet('search');
        if ($search) {
            $repair_shops = $this->repairShopModel->like('repair_shop_name', $search)
                                ->orLike('road_address', $search)
                                ->paginate($perPage);
        } else {
            $repair_shops = $this->repairShopModel->paginate($perPage);
        }

        // 뷰로 전달할 데이터
        return view('automobile_repair_shop/index', [
            'repair_shops' => $repair_shops,
            'pager' => $this->repairShopModel->pager,
            'search' => $search
        ]);
    }

    public function detail($id)
    {
        // 정비소 정보 가져오기
        $repair_shop = $this->repairShopModel->find($id);

        // 정비소가 없으면 404 에러 페이지 표시
        if (!$repair_shop) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('정비소를 찾을 수 없습니다.');
        }

        // 1km 이내의 다른 정비소
        $nearby_shops = $this->repairShopModel->getNearbyRepairShops($repair_shop['latitude'], $repair_shop['longitude'], 1);

        // 리뷰 정보 가져오기
        $reviews = $this->reviewModel->where('repair_shop_id', $id)->findAll();

        // 평균 평점 계산
        $averageRating = 0;
        if (count($reviews) > 0) {
            $averageRating = array_sum(array_column($reviews, 'rating')) / count($reviews);
        }

        // 디테일 뷰로 데이터 전달
        return view('automobile_repair_shop/detail', [
            'repair_shop' => $repair_shop,
            'nearby_shops' => $nearby_shops,
            'reviews' => $reviews,
            'averageRating' => $averageRating
        ]);
    }

    public function saveReview()
    {
        $repairShopId = $this->request->getPost('repair_shop_id');
        $rating = $this->request->getPost('rating');
        $commentText = $this->request->getPost('comment_text');

        // 리뷰 저장
        $this->reviewModel->save([
            'repair_shop_id' => $repairShopId,
            'rating' => $rating,
            'comment_text' => $commentText,
        ]);

        return redirect()->to("/automobile_repair_shop/{$repairShopId}");
    }
}
