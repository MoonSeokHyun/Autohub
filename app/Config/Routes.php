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

$routes->get('generate-sitemap', 'SitemapController::generate');
$routes->get('sitemap.xml', 'SitemapController::view');
$routes->get('sitemap_index.xml', 'SitemapController::index');
