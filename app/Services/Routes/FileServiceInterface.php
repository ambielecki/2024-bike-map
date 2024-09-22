<?php

namespace App\Services\Routes;

interface FileServiceInterface {
    public function getLatLongFromFile($file): array;
}
