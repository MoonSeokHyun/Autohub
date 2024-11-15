<?php

namespace App\Controllers;

use App\Models\SitemapModel;
use App\Models\ParkingLotModel;
use App\Models\GasStationModel;
use App\Models\AutomobileRepairShopModel;

class SitemapController extends BaseController
{
    protected $sitemapModel;

    public function __construct()
    {
        $this->sitemapModel = new SitemapModel();
    }

    // 사이트맵 인덱스 반환
    public function sitemapIndex()
    {
        $sections = ['parking', 'gas_stations', 'automobile_repair_shop'];
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($sections as $section) {
            $xml .= "<sitemap>\n";
            $xml .= "<loc>" . base_url("sitemap/{$section}") . "</loc>\n";
            $xml .= "<lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "</sitemap>\n";
        }

        $xml .= "</sitemapindex>";

        return $this->response
            ->setHeader('Content-Type', 'application/xml; charset=utf-8')
            ->setBody($xml);
    }

    // 특정 섹션의 사이트맵 반환
    public function section($section, $page = 1)
    {
        $modelMapping = [
            'parking' => [new ParkingLotModel(), 'parking'],
            'gas_stations' => [new GasStationModel(), 'gas_stations'],
            'automobile_repair_shop' => [new AutomobileRepairShopModel(), 'automobile_repair_shop']
        ];

        if (!isset($modelMapping[$section])) {
            return $this->failNotFound('Invalid section.');
        }

        [$model, $type] = $modelMapping[$section];
        $offset = ($page - 1) * $itemsPerPage;

        $urls = $this->sitemapModel->getUrlsByType($model, $type, $itemsPerPage, $offset);

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($urls as $url) {
            $xml .= "<url>\n";
            $xml .= "<loc>{$url['loc']}</loc>\n";
            $xml .= "<lastmod>{$url['lastmod']}</lastmod>\n";
            $xml .= "<changefreq>monthly</changefreq>\n";
            $xml .= "<priority>0.8</priority>\n";
            $xml .= "</url>\n";
        }

        $xml .= "</urlset>";

        return $this->response
            ->setHeader('Content-Type', 'application/xml; charset=utf-8')
            ->setBody($xml);
    }
}
