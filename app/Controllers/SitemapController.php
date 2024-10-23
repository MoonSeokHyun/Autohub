<?php

namespace App\Controllers;

use App\Models\GasStationModel;
use App\Models\ParkingLotModel;
use App\Models\AutomobileRepairShopModel;

class SitemapController extends BaseController
{
    public function generate()
    {
        // PHP 설정 변경 (타임아웃과 메모리 제한)
        set_time_limit(300); // 스크립트 최대 실행 시간 300초
        ini_set('memory_limit', '1024M'); // 메모리 제한 512MB

        // 모델 인스턴스 생성
        $gasStationModel = new GasStationModel();
        $parkingLotModel = new ParkingLotModel();
        $automobileRepairShopModel = new AutomobileRepairShopModel();

        // 각 모델에서 데이터 가져오기
        $gasStations = $gasStationModel->findAll();
        $parkingLots = $parkingLotModel->findAll();
        $repairShops = $automobileRepairShopModel->findAll();

        // 사이트맵 URL 배열
        $sitemapUrls = [];

        // 주유소 사이트맵 생성
        $this->createSitemap('gas_station', $gasStations, $sitemapUrls);
        // 주차장 사이트맵 생성
        $this->createSitemap('parking_lot', $parkingLots, $sitemapUrls);
        // 자동차 수리점 사이트맵 생성
        $this->createSitemap('automobile_repair_shop', $repairShops, $sitemapUrls);

        // 인덱스 XML 생성
        $indexContent = '<?xml version="1.0" encoding="UTF-8"?>';
        $indexContent .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap-image/1.1">';
        foreach ($sitemapUrls as $url) {
            $indexContent .= '<sitemap><loc>' . base_url($url) . '</loc></sitemap>';
        }
        $indexContent .= '</sitemapindex>';

        // 인덱스 파일 저장
        file_put_contents(APPPATH . 'Views/sitemaps/sitemap_index.xml', $indexContent);

        return '사이트맵과 인덱스가 생성되었습니다.';
    }

    private function createSitemap($type, $items, &$sitemapUrls)
    {
        $batchSize = 5000; // 한 번에 처리할 항목 수
        $totalItems = count($items);
        $sitemapIndex = 0;

        while ($totalItems > 0) {
            $sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>';
            $sitemapContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap-image/1.1">';

            // 현재 배치의 항목 추출
            $currentItems = array_splice($items, 0, $batchSize);
            foreach ($currentItems as $item) {
                $url = base_url("{$type}/{$item['id']}");
                $sitemapContent .= '<url>';
                $sitemapContent .= '<loc>' . $url . '</loc>';
                $sitemapContent .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
                $sitemapContent .= '<changefreq>monthly</changefreq>';
                $sitemapContent .= '<priority>0.5</priority>';
                $sitemapContent .= '</url>';
            }

            $sitemapContent .= '</urlset>';

            // 파일 저장
            $filePath = APPPATH . "Views/sitemaps/{$type}_{$sitemapIndex}.xml"; // 인덱스 추가
            file_put_contents($filePath, $sitemapContent);
            $sitemapUrls[] = "sitemaps/{$type}_{$sitemapIndex}.xml"; // URL 추가

            $sitemapIndex++;
            $totalItems -= $batchSize;
        }
    }

    public function view()
    {
        return $this->response->download(APPPATH . 'Views/sitemaps/sitemap.xml', null);
    }

    public function index()
    {
        return $this->response->download(APPPATH . 'Views/sitemaps/sitemap_index.xml', null);
    }
}
