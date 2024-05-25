<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id', 'notice', 'for_date', 'start_at', 'duration'];

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (filled($value) && $value == 'not_complete') {
                    $value = explode('_', $value);
                    $value = $value[0] . " " . $value[1];
                    return $value;
                } else {
                    return $value;
                }
            }
        );
    }
    public function subtasks(): HasMany
    {
        return $this->hasMany(SubTask::class);
    }
}
