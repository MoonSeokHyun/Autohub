<?php

namespace App\Models;

use CodeIgniter\Model;

class SitemapModel extends Model
{
    protected $parkingLotModel;
    protected $gasStationModel;
    protected $automobileRepairShopModel;

    public function __construct()
    {
        parent::__construct();
        $this->parkingLotModel = new ParkingLotModel();
        $this->gasStationModel = new GasStationModel();
        $this->automobileRepairShopModel = new AutomobileRepairShopModel();
    }

    // 주차장 URL 가져오기
    public function getParkingLotUrls()
    {
        $parkingLots = $this->parkingLotModel->findAll();
        $urls = [];
        
        foreach ($parkingLots as $lot) {
            $urls[] = [
                'loc' => base_url("parking/detail/{$lot['id']}"),
                'lastmod' => $lot['data_reference_date'] ?? date('Y-m-d')
            ];
        }

        return $urls;
    }

    // 주유소 URL 가져오기
    public function getGasStationUrls()
    {
        $gasStations = $this->gasStationModel->findAll();
        $urls = [];
        
        foreach ($gasStations as $station) {
            $urls[] = [
                'loc' => base_url("gas_stations/{$station['id']}"),
                'lastmod' => $station['data_reference_date'] ?? date('Y-m-d')
            ];
        }

        return $urls;
    }

    // 자동차 정비소 URL 가져오기
    public function getAutomobileRepairShopUrls()
    {
        $repairShops = $this->automobileRepairShopModel->findAll();
        $urls = [];
        
        foreach ($repairShops as $shop) {
            $urls[] = [
                'loc' => base_url("automobile_repair_shop/{$shop['id']}"),
                'lastmod' => $shop['data_reference_date'] ?? date('Y-m-d')
            ];
        }

        return $urls;
    }

    // 모든 URL 가져오기
    public function getAllUrls()
    {
        return array_merge(
            $this->getParkingLotUrls(),
            $this->getGasStationUrls(),
            $this->getAutomobileRepairShopUrls()
        );
    }

    // 사이트맵 XML 파일 생성
    public function createSitemap($batchSize = 50000)
    {
        $urls = $this->getAllUrls();
        $totalUrls = count($urls);
        $batchCount = ceil($totalUrls / $batchSize); // 배치 수

        // 디렉토리가 없으면 생성
        if (!is_dir(WRITEPATH . 'sitemaps')) {
            mkdir(WRITEPATH . 'sitemaps', 0777, true);
        }

        for ($i = 0; $i < $batchCount; $i++) {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap-image/1.1">';

            // 현재 배치의 URL 가져오기
            $currentBatch = array_slice($urls, $i * $batchSize, $batchSize);
            foreach ($currentBatch as $url) {
                $xml .= '<url>';
                $xml .= '<loc>' . esc($url['loc']) . '</loc>';
                $xml .= '<lastmod>' . esc($url['lastmod']) . '</lastmod>';
                $xml .= '</url>';
            }

            $xml .= '</urlset>';

            // 파일 경로 설정
            $filePath = WRITEPATH . 'sitemaps/sitemap_' . ($i + 1) . '.xml';
            file_put_contents($filePath, $xml);
        }

        return $batchCount; // 생성된 배치 수 반환
    }

    // 이미 생성된 XML 파일 목록 가져오기
    public function getSitemapFiles()
    {
        $files = glob(WRITEPATH . 'sitemaps/*.xml');
        return array_map('basename', $files); // 파일 이름만 반환
    }
}
