<?php

namespace App\Controllers;

use App\Models\SitemapModel;
use CodeIgniter\RESTful\ResourceController;

class SitemapController extends ResourceController
{
    protected $sitemapModel;

    public function __construct()
    {
        ini_set('memory_limit', '512M'); // PHP 메모리 한도 증가
        ini_set('max_execution_time', '300'); // 최대 실행 시간 증가 (초 단위)
        $this->sitemapModel = new SitemapModel();
    }

    // 사이트맵 생성
    public function generateSitemap()
    {
        try {
            $batchCount = $this->sitemapModel->createSitemap();
            return $this->respond(['message' => $batchCount . '개의 사이트맵 파일이 생성되었습니다.'], 200);
        } catch (\Exception $e) {
            return $this->failServerError('사이트맵 생성 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    // 사이트맵 인덱스 반환
    public function sitemapIndex()
    {
        $files = $this->sitemapModel->getSitemapFiles();
        $filteredFiles = array_filter($files, function($file) {
            return preg_match('/^sitemap_\d+\.xml$/', $file); // "sitemap_숫자.xml" 패턴에 맞는 파일만 포함
        });
        
        // 공백 제거 (유니코드 BOM 제거)
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($filteredFiles as $file) {
            $xml .= '<sitemap>';
            $xml .= '<loc>' . base_url("sitemap/view/{$file}") . '</loc>'; // 실제 접근 가능한 URL로 수정
            $xml .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
            $xml .= '</sitemap>';
        }

        $xml .= '</sitemapindex>';

        return $this->response->setContentType('application/xml')->setBody($xml);
    }

    // 개별 사이트맵 파일 보기
    public function viewSitemap($filename)
    {
        $filePath = WRITEPATH . 'sitemaps/' . $filename;

        if (file_exists($filePath)) {
            // 공백 제거 (유니코드 BOM 제거)
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            $xmlContent = file_get_contents($filePath);
            return $this->response->setContentType('application/xml')->setBody($xmlContent);
        } else {
            return $this->failNotFound('해당 사이트맵 파일을 찾을 수 없습니다.');
        }
    }
}

?>

