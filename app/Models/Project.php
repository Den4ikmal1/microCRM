<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Project extends Model
{
    const PLANNED   = 0;
    const RUNNING   = 1;
    const ON_HOLD   = 2;
    const FINISHED  = 3;
    const CANCELLED = 4;

    protected static $statuses = [
        'Planned',
        'Running',
        'OnHold',
        'Finished',
        'Cancelled'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'status'
    ];

    public function getStatusAttribute($value)
    {
        return Arr::get(static::$statuses, $value);
    }

    public static function getKeyStatuses()
    {
        return array_keys(static::$statuses);
    }
}