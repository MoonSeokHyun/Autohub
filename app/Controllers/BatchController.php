<?php

namespace App\Controllers;

use App\Services\ParkingService;
use CodeIgniter\CLI\CLI;

class BatchController extends BaseController
{
    protected $parkingService;

    public function __construct()
    {
        $this->parkingService = new ParkingService();
    }

    public function updateParkingData()
    {
        $result = $this->parkingService->updateParkingData();
        $message = 'Parking data updated successfully.';

        if ($result['updated'] > 0 || $result['inserted'] > 0) {
            $message .= ' Updated records: ' . $result['updated'] . ', Inserted records: ' . $result['inserted'] . '.';
        } else {
            $message .= ' No changes were made.';
        }

        if (is_cli()) {
            CLI::write($message, 'green');
        } else {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => $message,
                'updated' => $result['updated'],
                'inserted' => $result['inserted']
            ]);
        }
    }
}
