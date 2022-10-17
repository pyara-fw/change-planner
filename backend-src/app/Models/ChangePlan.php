<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangePlan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'change_plans';

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
    protected $fillable = ['description', 'change_request_id', 'status'];

    public function changeRequest()
    {
        return $this->belongsTo('App\Models\ChangeRequest');
    }
}
