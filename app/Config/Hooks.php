<?php

$hooks['post_controller_constructor'][] = function () {
    $scheduler = new \App\Libraries\Scheduler();
    $scheduler->run();
};

$hooks['post_controller_constructor'][] = function () {
    $gasStationScheduler = new \App\Libraries\GasStationScheduler();
    $gasStationScheduler->run();
};
