<?php

namespace App\Libraries;

use App\Controllers\GasStationBatchController;
use CodeIgniter\I18n\Time;

class GasStationScheduler
{
    protected $lastRunTime;

    public function __construct()
    {
        $this->lastRunTime = cache('lastRunTimeGasStation');
    }

    public function run()
    {
        $now = Time::now('Asia/Seoul');

        // 매일 새벽 2시 30분에 배치 실행
        if (!$this->lastRunTime || $this->lastRunTime->isBefore($now->setTime(2, 30))) {
            $batchController = new GasStationBatchController();
            $batchController->updateGasStationData();

            // 마지막 실행 시간 갱신
            cache()->save('lastRunTimeGasStation', $now, 86400); // 24시간 동안 캐시 유지
        }
    }
}
