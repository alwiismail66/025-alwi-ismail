<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubTask extends Model
{
    use HasFactory;
    protected $fillable = [ 'task_id', 'name' ];
    protected function status () : Attribute
    {
        return Attribute::make (
            get:
            function ($value)
            {
                if (filled ( $value ) && $value == 'not_complete')
                {
                    $value = explode ( '_', $value );
                    $value = $value[ 0 ] . " " . $value[ 1 ];
                    return $value;
                }
                else
                {
                    return $value;
                }
            }
        );
    }
    public function task () : BelongsTo
    {
        return $this->belongsTo ( Task::class);
    }
}
