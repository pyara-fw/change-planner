<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'evaluations';

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
    protected $fillable = ['data', 'description', 'solution_id', 'user_id'];

    public function user_id()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function solution()
    {
        return $this->belongsTo('App\Models\Solution');
    }
    
}
