<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'change_requests';

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
    protected $fillable = ['title', 'description', 'project_id', 'reporter_user_id', 'assigned_user_id', 'status'];

    public function assigned_to()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function reported_by()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
    
}
