<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Vehicle extends Model
{
    use HasFactory;

    public function scopeMakeLike(Builder $query, string | null $make)
    {
        return $this->scopeLikeColumn($query, 'make', $make);
    }

    public function scopeRegistrationLike(Builder $query, string | null $registration)
    {
        return $this->scopeLikeColumn($query, 'registration', $registration);
    }

    public function scopeModelLike(Builder $query, string | null $model)
    {
        return $this->scopeLikeColumn($query, 'model', $model);
    }

    private function scopeLikeColumn(Builder $query, string $column, string | null $value)
    {
        if ($value) {
            $query = $query->where($column, 'like', "%$value%");
        }
        return $query;
    }
}
