<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemSolution extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'item_solutions';

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
    protected $fillable = ['title', 'description', 'solution_id'];

    public function solution()
    {
        return $this->belongsTo('App\Models\Solution');
    }

    public function getFormattedDescription()
    {
        $parsedown = new \ParsedownExtra();
        return $parsedown->text($this->description);
    }
}
