<?php

namespace App\Models;

use CodeIgniter\Model;

class SitemapModel extends Model
{
    protected $batchSize = 2000;

    // 특정 타입의 URL을 메모리에서 생성
    public function getUrlsByType($model, $type, $limit, $offset)
    {
        $data = $model->findAll($limit, $offset);
        $urls = [];

        foreach ($data as $item) {
            $urls[] = [
                'loc' => base_url("{$type}/detail/{$item['id']}"),
                'lastmod' => $item['data_reference_date'] ?? date('Y-m-d'),
            ];
        }

        return $urls;
    }

    // 특정 타입의 총 개수 반환
    public function countUrlsByType($model)
    {
        return $model->countAll();
    }
}
