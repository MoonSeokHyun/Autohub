<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ParkingLotModel;
use App\Models\GasStationModel;
use App\Models\AutomobileRepairShopModel;

class SitemapController extends Controller
{
    public function index()
    {
        // PHP 메모리와 타임아웃 설정
        ini_set('memory_limit', '512M');  // 메모리 제한
        set_time_limit(0);                 // 타임아웃 무제한
        ini_set('max_execution_time', 300); // 최대 실행 시간 300초

        // 모델 로드
        $parkingLotModel = new ParkingLotModel();
        $gasStationModel = new GasStationModel();
        $automobileRepairShopModel = new AutomobileRepairShopModel();

        // 데이터베이스에서 각 테이블의 모든 항목 가져오기
        $parkings = $parkingLotModel->findAll();
        $gasStations = $gasStationModel->findAll();
        $automobileRepairShops = $automobileRepairShopModel->findAll();

        // 기본 URL 배열
        $urls = [
            base_url('/'),                     // 메인 페이지
            base_url('/gas_stations'),          // 주유소 페이지
            base_url('/automobile_repair_shops'), // 정비소 페이지
            base_url('/parking')                // 주차장 페이지
        ];

        // 사이트맵 초기화
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $urlCount = 0;

        // 기본 URL을 사이트맵에 추가
        foreach ($urls as $url) {
            $sitemap .= $this->generateUrl($url);
            $urlCount++;
        }

        // 주차장 URL 추가
        foreach ($parkings as $parking) {
            $sitemap .= $this->generateUrl(base_url('parking/detail/' . $parking['id']));
            $urlCount++;
        }

        // 주유소 URL 추가
        foreach ($gasStations as $gasStation) {
            $sitemap .= $this->generateUrl(base_url('gas_stations/' . $gasStation['id']));
            $urlCount++;
        }

        // 자동차 정비소 URL 추가
        foreach ($automobileRepairShops as $shop) {
            $sitemap .= $this->generateUrl(base_url('automobile_repair_shop/' . $shop['id']));
            $urlCount++;
        }

        // 마지막 URL 닫기
        $sitemap .= '</urlset>';

        // 사이트맵 파일 저장 (public 디렉토리에 저장)
        file_put_contents(FCPATH . 'public/sitemap.xml', $sitemap);

        // 웹에서 바로 제공
        return $this->response->setHeader('Content-Type', 'application/xml')
            ->setBody(file_get_contents(FCPATH . 'public/sitemap.xml'));
    }

    // 사이트맵 URL 생성 함수
    private function generateUrl($loc)
    {
        return '
            <url>
                <loc>' . $loc . '</loc>
                <changefreq>daily</changefreq>
                <priority>0.8</priority>
            </url>';
    }
}
