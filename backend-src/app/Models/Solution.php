<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solution extends Model
{
    use SoftDeletes;

    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_SUBMITTED = 2;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'solutions';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'task_id', 'user_id', 'status'];

    public function assigned_to()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }

    public function status()
    {
        if ($this->status === 2) {
            $status = 'Submitted';
        } else {
            $status = 'In progress';
        }
        return $status;
    }
}
