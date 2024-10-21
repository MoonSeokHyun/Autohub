<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Response;

class SitemapController extends Controller
{
    public function index()
    {
        // Sitemap의 각 URL을 배열로 정의
        $urls = [
            base_url('/'), // 메인 페이지
            base_url('/gas_stations'), // 주유소 페이지
            base_url('/automobile_repair_shops'), // 정비소 페이지
            base_url('/parking') // 주차장 페이지
        ];

        // XML 문서 시작
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // 각 URL을 사이트맵에 추가
        foreach ($urls as $url) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . $url . '</loc>';
            $sitemap .= '<changefreq>daily</changefreq>'; // 페이지 변경 빈도 설정
            $sitemap .= '<priority>0.8</priority>'; // 우선 순위 설정
            $sitemap .= '</url>';
        }

        $sitemap .= '</urlset>';

        // 응답으로 XML 파일 출력
        $this->response->setHeader('Content-Type', 'application/xml');
        return $this->response->setBody($sitemap);
    }
}
