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
        ini_set('memory_limit', '512M');
        set_time_limit(0);
        ini_set('max_execution_time', 300);

        // 모델 로드
        $parkingLotModel = new ParkingLotModel();
        $gasStationModel = new GasStationModel();
        $automobileRepairShopModel = new AutomobileRepairShopModel();

        // 데이터베이스에서 항목을 배치로 가져오기
        $batchSize = 1000;
        $urls = [
            base_url('/'),
            base_url('/gas_stations'),
            base_url('/automobile_repair_shops'),
            base_url('/parking')
        ];

        // 사이트맵을 분할 저장할 번호
        $fileIndex = 1;
        $urlCount = 0;
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // 기본 URL을 사이트맵에 추가
        foreach ($urls as $url) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . $url . '</loc>';
            $sitemap .= '<changefreq>daily</changefreq>';
            $sitemap .= '<priority>0.8</priority>';
            $sitemap .= '</url>';
            $urlCount++;
            if ($urlCount >= 30000) {
                // 30,000개마다 새 파일로 저장
                file_put_contents(FCPATH . "sitemap_$fileIndex.xml", $sitemap . '</urlset>');
                $fileIndex++;
                $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
                $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                $urlCount = 0;
            }
        }

        // 주차장 URL 추가
        $offset = 0;
        while ($parkings = $parkingLotModel->findAll($batchSize, $offset)) {
            foreach ($parkings as $parking) {
                $sitemap .= '<url>';
                $sitemap .= '<loc>' . base_url('parking/detail/' . $parking['id']) . '</loc>';
                $sitemap .= '<changefreq>daily</changefreq>';
                $sitemap .= '<priority>0.8</priority>';
                $sitemap .= '</url>';
                $urlCount++;
                if ($urlCount >= 30000) {
                    file_put_contents(FCPATH . "sitemap_$fileIndex.xml", $sitemap . '</urlset>');
                    $fileIndex++;
                    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
                    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                    $urlCount = 0;
                }
            }
            $offset += $batchSize;
        }

        // 주유소 URL 추가
        $offset = 0;
        while ($gasStations = $gasStationModel->findAll($batchSize, $offset)) {
            foreach ($gasStations as $gasStation) {
                $sitemap .= '<url>';
                $sitemap .= '<loc>' . base_url('gas_stations/' . $gasStation['id']) . '</loc>';
                $sitemap .= '<changefreq>daily</changefreq>';
                $sitemap .= '<priority>0.8</priority>';
                $sitemap .= '</url>';
                $urlCount++;
                if ($urlCount >= 30000) {
                    file_put_contents(FCPATH . "sitemap_$fileIndex.xml", $sitemap . '</urlset>');
                    $fileIndex++;
                    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
                    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                    $urlCount = 0;
                }
            }
            $offset += $batchSize;
        }

        // 자동차 정비소 URL 추가
        $offset = 0;
        while ($automobileRepairShops = $automobileRepairShopModel->findAll($batchSize, $offset)) {
            foreach ($automobileRepairShops as $shop) {
                $sitemap .= '<url>';
                $sitemap .= '<loc>' . base_url('automobile_repair_shop/' . $shop['id']) . '</loc>';
                $sitemap .= '<changefreq>daily</changefreq>';
                $sitemap .= '<priority>0.8</priority>';
                $sitemap .= '</url>';
                $urlCount++;
                if ($urlCount >= 30000) {
                    file_put_contents(FCPATH . "sitemap_$fileIndex.xml", $sitemap . '</urlset>');
                    $fileIndex++;
                    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
                    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                    $urlCount = 0;
                }
            }
            $offset += $batchSize;
        }

        // 마지막 파일 저장
        if ($urlCount > 0) {
            file_put_contents(FCPATH . "sitemap_$fileIndex.xml", $sitemap . '</urlset>');
        }

        // Git에 파일 추가 및 커밋
        exec('git add ' . FCPATH . 'sitemap_*.xml');
        exec('git commit -m "Update sitemap"');
        exec('git push origin master');

        // 응답으로 사이트맵 파일 출력 (첫 번째 파일만 출력)
        $this->response->setHeader('Content-Type', 'application/xml');
        return $this->response->setBody(file_get_contents(FCPATH . "sitemap_1.xml"));
    }
}
