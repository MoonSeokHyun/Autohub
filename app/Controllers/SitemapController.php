<?php

namespace App\Controllers;

use App\Models\ParkingLotModel;
use App\Models\GasStationModel;
use App\Models\AutomobileRepairShopModel;

class SitemapController extends BaseController
{
    public function index()
    {
        // URL 기본 정보
        $base_url = 'https://carhub.co.kr';
        
        // 주차장, 주유소, 정비소의 URL 목록을 생성
        $parking_lots = $this->generateUrls('parking/detail', 16070, 32138);
        $gas_stations = $this->generateUrls('gas_station', 1, 2757);
        $automobile_repair_shops = $this->generateUrls('automobile_repair_shop', 1, 35512);

        // 사이트맵 파일 생성
        $this->createSitemap($parking_lots, 'parking');
        $this->createSitemap($gas_stations, 'gas_station');
        $this->createSitemap($automobile_repair_shops, 'automobile_repair_shop');

        // 사이트맵 인덱스 생성
        $sitemaps = [
            "{$base_url}/writable/sitemaps/parking_sitemap_index.xml",
            "{$base_url}/writable/sitemaps/gas_station_sitemap_index.xml",
            "{$base_url}/writable/sitemaps/automobile_repair_shop_sitemap_index.xml",
        ];

        // Content-Type 헤더 추가
        header('Content-Type: application/xml; charset=utf-8');
        
        // XML 인덱스 뷰 출력
        return view('sitemaps/sitemap_index', ['sitemaps' => $sitemaps]);
    }

    private function generateUrls($type, $start, $end)
    {
        $urls = [];
        for ($i = $start; $i <= $end; $i++) {
            $urls[] = [
                'loc' => "https://carhub.co.kr/{$type}/{$i}",
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ];
        }
        return $urls;
    }

    private function createSitemap($urls, $type)
    {
        $base_path = WRITEPATH . 'sitemaps/';
        $count = 0;
        $index = 1;
        $url_count = count($urls);
        $max_urls = 50000; // 사이트맵에 포함할 최대 URL 수

        while ($count < $url_count) {
            // 5만 개씩 나누어 사이트맵 생성
            $current_urls = array_slice($urls, $count, $max_urls);
            $sitemap_content = $this->generateSitemapXml($current_urls);
            $sitemap_file = "{$base_path}{$type}_sitemap_{$index}.xml";

            // 사이트맵 파일 생성
            file_put_contents($sitemap_file, $sitemap_content);

            $count += $max_urls;
            $index++;
        }

        // 사이트맵 인덱스 생성
        $this->createSitemapIndex($type, $index - 1);
    }

    private function generateSitemapXml($urls)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . $url['loc'] . '</loc>';  // esc() 제거
            $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';  // esc() 제거
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';  // esc() 제거
            $xml .= '<priority>' . $url['priority'] . '</priority>';  // esc() 제거
            $xml .= '</url>';
        }

        $xml .= '</urlset>';
        return $xml;
    }

    private function createSitemapIndex($type, $index)
    {
        $base_path = WRITEPATH . 'sitemaps/';
        $sitemap_index_content = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap_index_content .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        for ($i = 1; $i <= $index; $i++) {
            $sitemap_index_content .= '<sitemap>';
            $sitemap_index_content .= '<loc>https://carhub.co.kr/writable/sitemaps/' . $type . '_sitemap_' . $i . '.xml</loc>';  // esc() 제거
            $sitemap_index_content .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
            $sitemap_index_content .= '</sitemap>';
        }

        $sitemap_index_content .= '</sitemapindex>';

        // 사이트맵 인덱스 파일 생성
        file_put_contents("{$base_path}{$type}_sitemap_index.xml", $sitemap_index_content);
    }
}
