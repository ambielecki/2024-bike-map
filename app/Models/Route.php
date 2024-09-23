<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $appends = ['date'];

    protected function data(): Attribute {
        return Attribute::make(
            get: fn (string $value) => json_decode($value, true),
            set: fn ($value) => json_encode($value)
        );
    }

    protected function latLng(): Attribute {
        return Attribute::make(
            get: fn (string $value) => json_decode($value, true),
            set: fn ($value) => json_encode($value)
        );
    }

    protected function date(): Attribute {
        return Attribute::make(
            get: function ($value, array $attributes) {
                return date('Y-m-d H:i', $attributes['timestamp']);
            },
        );
    }
}
