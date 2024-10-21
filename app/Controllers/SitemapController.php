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
        ini_set('memory_limit', '512M');   // 메모리 제한을 512MB로 설정
        set_time_limit(0);                  // 타임아웃을 무제한으로 설정
        ini_set('max_execution_time', 300); // 최대 실행 시간을 300초로 설정

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
            base_url('/'), // 메인 페이지
            base_url('/gas_stations'), // 주유소 페이지
            base_url('/automobile_repair_shops'), // 정비소 페이지
            base_url('/parking') // 주차장 페이지
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
            $sitemap .= '<changefreq>daily</changefreq>'; // 페이지 변경 빈도 설정
            $sitemap .= '<priority>0.8</priority>'; // 우선 순위 설정
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
        foreach ($parkings as $parking) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . base_url('parking/detail/' . $parking['id']) . '</loc>';
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

        // 주유소 URL 추가
        foreach ($gasStations as $gasStation) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . base_url('gas_stations/' . $gasStation['id']) . '</loc>';
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

        // 자동차 정비소 URL 추가
        foreach ($automobileRepairShops as $shop) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . base_url('automobile_repair_shop/' . $shop['id']) . '</loc>';
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

        // 마지막 파일 저장
        if ($urlCount > 0) {
            file_put_contents(FCPATH . "sitemap_$fileIndex.xml", $sitemap . '</urlset>');
        }

        // 응답으로 사이트맵 파일 출력 (첫 번째 파일만 출력)
        $this->response->setHeader('Content-Type', 'application/xml');
        return $this->response->setBody(file_get_contents(FCPATH . "sitemap_1.xml"));
    }
}
