<?php

namespace App\Controllers;

use App\Models\AutomobileRepairShopModel;
use App\Models\AutomobileRepairShopReviewModel;

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
        $pager = \Config\Services::pager();
        $perPage = 5;

        // 검색어 필터링
        $search = $this->request->getGet('search');
        if ($search) {
            $repair_shops = $this->repairShopModel->like('repair_shop_name', $search)
                                ->orLike('road_address', $search)
                                ->paginate($perPage);
        } else {
            $repair_shops = $this->repairShopModel->paginate($perPage);
        }

        // 최근 추가된 정비소
        $recentRepairShops = $this->repairShopModel->orderBy('id', 'DESC')->findAll(5);

        // 인기 정비소: 리뷰 개수와 평균 평점을 조인하여 가져오기
        $popularRepairShops = $this->repairShopModel
            ->select('automobile_repair_shop.id as repair_shop_id, automobile_repair_shop.repair_shop_name, COUNT(automobile_repair_shop_reviews.id) as review_count, AVG(automobile_repair_shop_reviews.rating) as average_rating')
            ->join('automobile_repair_shop_reviews', 'automobile_repair_shop.id = automobile_repair_shop_reviews.repair_shop_id', 'left')
            ->groupBy('automobile_repair_shop.id')
            ->orderBy('review_count', 'DESC')
            ->findAll(5);

        // 최근 리뷰와 함께 정비소 이름 가져오기
        $recentReviews = $this->reviewModel
            ->select('automobile_repair_shop_reviews.*, automobile_repair_shop.repair_shop_name')
            ->join('automobile_repair_shop', 'automobile_repair_shop_reviews.repair_shop_id = automobile_repair_shop.id', 'left')
            ->orderBy('automobile_repair_shop_reviews.id', 'DESC')
            ->findAll(5);

        return view('automobile_repair_shop/index', [
            'repair_shops' => $repair_shops,
            'pager' => $this->repairShopModel->pager,
            'search' => $search,
            'recentRepairShops' => $recentRepairShops,
            'popularRepairShops' => $popularRepairShops,
            'recentReviews' => $recentReviews
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

        // 정비소에 대한 모든 리뷰 가져오기
        $reviews = $this->reviewModel->where('repair_shop_id', $id)->orderBy('id', 'DESC')->findAll();
        $averageRating = $this->reviewModel->getAverageRating($id);

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

        $this->reviewModel->save([
            'repair_shop_id' => $repairShopId,
            'rating' => $rating,
            'comment_text' => $commentText,
        ]);

        return redirect()->to("/automobile_repair_shop/{$repairShopId}");
    }
}
