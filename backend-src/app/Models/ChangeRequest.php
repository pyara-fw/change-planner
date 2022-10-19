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
        return $this->belongsTo('App\Models\User', 'assigned_user_id', 'id');
    }
    public function reported_by()
    {
        return $this->belongsTo('App\Models\User', 'reporter_user_id', 'id');
    }
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function statusTitle($status=null)
    {
        $statusArr = [
            '1' => 'Pending',
            '2' => 'Executing',
            '3' => 'Planned',
        ];

        if (!$status) {
            $status = $this->status;
        }
        return $statusArr[$status] ?? 'Unknown';
    }
}
