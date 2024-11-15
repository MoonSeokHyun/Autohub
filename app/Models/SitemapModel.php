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
            $baseUrl = base_url($type);

            // parking 섹션은 "detail" 경로 포함
            if ($type === 'parking') {
                $urls[] = [
                    'loc' => "{$baseUrl}/detail/{$item['id']}",
                    'lastmod' => $item['data_reference_date'] ?? date('Y-m-d'),
                ];
            } else {
                // gas_stations 및 automobile_repair_shop 섹션은 "id"만 추가
                $urls[] = [
                    'loc' => "{$baseUrl}/{$item['id']}",
                    'lastmod' => $item['data_reference_date'] ?? date('Y-m-d'),
                ];
            }
        }

        return $urls;
    }

    // 특정 타입의 총 개수 반환
    public function countUrlsByType($model)
    {
        return $model->countAll();
    }
}
