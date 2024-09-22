<?php

namespace App\Services\Routes;

use adriangibbons\phpFITFileAnalysis;

class FitFileService implements FileServiceInterface {
    public function getLatLongFromFile($file): array {
        $analysis = new phpFITFileAnalysis($file);

        $positions = [];
        $record = $analysis->data_mesgs['record'];

        foreach ($record['timestamp'] as $timeStamp) {
            $latitude = $record['position_lat'][$timeStamp] ?? null;
            $longitude = $record['position_long'][$timeStamp] ?? null;

            if ($latitude && $longitude) {
                $positions[$timeStamp] = [
                    'lat' => $latitude,
                    'lng' => $longitude,
                ];
            }
        }

        return $positions;
    }

    public function getTimestampFromFile ($file): ?int {
        $analysis = new phpFITFileAnalysis($file);

        return $analysis->data_mesgs['file_id']['time_created'] ?? null;
    }
}
