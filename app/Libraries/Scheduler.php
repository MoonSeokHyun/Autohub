<?php

namespace App\Libraries;

use App\Controllers\BatchController;
use CodeIgniter\I18n\Time;

class Scheduler
{
    protected $lastRunTime;

    public function __construct()
    {
        // 이전 실행 시간을 캐시에서 불러옴
        $this->lastRunTime = cache('lastRunTime');
    }

    public function run()
    {
        // 한국 표준시 (KST) 시간으로 현재 시간 가져오기
        $now = Time::now('Asia/Seoul');
        
        // 매일 새벽 2시에 배치 실행 (이전 실행 시간 이후로 24시간이 지났을 경우)
        if (!$this->lastRunTime || $this->lastRunTime->isBefore($now->setTime(2, 0))) {
            $batchController = new BatchController();
            $batchController->updateParkingData();

            // 마지막 실행 시간 갱신
            cache()->save('lastRunTime', $now, 86400); // 24시간 동안 캐시 유지
        }
    }
}
