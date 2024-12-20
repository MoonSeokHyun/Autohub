<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 기본 설정된 라우트
$routes->get('/', 'ParkingController::index'); // 기본 페이지를 ParkingController의 index로 변경
$routes->get('parking', 'ParkingController::index');
$routes->get('parking/search', 'ParkingController::search');
$routes->get('parking/detail/(:num)', 'ParkingController::detail/$1');
$routes->get('gas_stations', 'GasStationController::index');
$routes->get('gas_stations/(:num)', 'GasStationController::detail/$1');

// 자동차 정비소 라우트 추가
$routes->get('/automobile_repair_shops', 'AutomobileRepairShopController::index');
$routes->get('/automobile_repair_shop/(:num)', 'AutomobileRepairShopController::detail/$1');

$routes->get('gas_stations/search', 'GasStationController::search');
// 자동차 정비소 검색 라우트 추가
$routes->get('automobile_repair_shops/search', 'AutomobileRepairShopController::search');


// 배치 관련 

$routes->cli('batch/update-parking-data', 'BatchController::updateParkingData');
$routes->get('/batch/update-parking-data', 'BatchController::updateParkingData');

// 주유소 배치 
$routes->cli('batch/update-gas-station-data', 'GasStationBatchController::updateGasStationData');
$routes->get('/batch/update-gas-station-data', 'GasStationBatchController::updateGasStationData');

// 주차장 댓글 
$routes->post('parking/saveComment', 'ParkingController::saveComment');
// 주유소 댓글 
$routes->post('/gas_station/saveComment', 'GasStationController::saveComment');
// 정비소 댓글
$routes->post('automobile_repair_shop/saveReview', 'AutomobileRepairShopController::saveReview');

$routes->get('sitemap', 'SitemapController::sitemapIndex');
$routes->get('sitemap/(:segment)/(:num)', 'SitemapController::section/$1/$2');
$routes->get('sitemap/(:segment)', 'SitemapController::section/$1/1');
