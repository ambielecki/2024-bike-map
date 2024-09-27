<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Location\Coordinate;
use Location\Polygon;

class Exclusion extends Model
{
    use HasFactory;

    protected function points(): Attribute {
        return Attribute::make(
            get: fn (string $value) => json_decode($value, true),
            set: fn ($value) => json_encode($value)
        );
    }

    public function getPolygon(): Polygon {
        $zone = new Polygon();
        foreach ($this->points as $point) {
            $zone->addPoint(new Coordinate($point[0], $point[1]));
        }

        return $zone;
    }
}
