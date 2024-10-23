<?php

namespace App\Controllers;

use App\Models\SitemapModel;
use CodeIgniter\RESTful\ResourceController;

class SitemapController extends ResourceController
{
    protected $sitemapModel;

    public function __construct()
    {
        ini_set('memory_limit', '512M'); // PHP memory limit increase
        ini_set('max_execution_time', '300'); // Increase max execution time (in seconds)
        $this->sitemapModel = new SitemapModel();
    }

    // Generate Sitemap
    public function generateSitemap()
    {
        try {
            $batchCount = $this->sitemapModel->createSitemap(2000);
            return $this->respond(['message' => $batchCount . ' sitemap files have been generated.'], 200);
        } catch (\Exception $e) {
            return $this->failServerError('An error occurred while generating the sitemap: ' . $e->getMessage());
        }
    }

    // Return Sitemap Index
    public function sitemapIndex()
    {
        $files = $this->sitemapModel->getSitemapFiles();
        $filteredFiles = array_filter($files, function($file) {
            return preg_match('/^sitemap_\d+\.xml$/', $file); // Only include files matching "sitemap_number.xml" pattern
        });
        
        // Clear any previous output (Unicode BOM removal)
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        header('Content-Type: application/xml; charset=UTF-8'); // Explicitly set XML content type for immediate rendering
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($filteredFiles as $file) {
            $xml .= '<sitemap>';
            $xml .= '<loc>' . base_url("sitemap/view/{$file}") . '</loc>'; // Update to actual accessible URL
            $xml .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
            $xml .= '</sitemap>';
        }

        $xml .= '</sitemapindex>';

        echo $xml;
        exit;
    }

    // View individual sitemap file
    public function viewSitemap($filename)
    {
        $filePath = WRITEPATH . 'sitemaps/' . $filename;

        if (file_exists($filePath)) {
            // Clear any previous output (Unicode BOM removal)
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            header('Content-Type: application/xml; charset=UTF-8'); // Explicitly set XML content type for immediate rendering
            
            $xmlContent = file_get_contents($filePath);
            
            // Ensure namespace is added
            if (strpos($xmlContent, 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"') === false) {
                $xmlContent = str_replace('<urlset>', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $xmlContent);
            }
            
            echo $xmlContent;
            exit;
        } else {
            return $this->failNotFound('The specified sitemap file could not be found.');
        }
    }
}

?>
