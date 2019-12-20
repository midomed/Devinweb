<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_name','imageable_type','imageable_id','slug'];

    /**
     * Get the owning imageable model.
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
