<?php

namespace App\Controllers;

use App\Services\GasStationService;
use CodeIgniter\CLI\CLI;

class GasStationBatchController extends BaseController
{
    protected $gasStationService;

    public function __construct()
    {
        $this->gasStationService = new GasStationService();
    }

    public function updateGasStationData()
    {
        $result = $this->gasStationService->updateGasStationData();
        $message = 'Gas station data updated successfully.';

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
