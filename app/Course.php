<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
class Course extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id','name','description','slug'];


    /**
     * Get the post's image.
     */
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    /**
     * delete attached image
     * @return JsonResponse
     */
    public function deleteAttachedImage()
    {
        try {
            if ($this->image) {
                Storage::disk('public')->delete('courses/' . $this->image->file_name);
                $this->image()->delete();
            }
        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Get the category that owns the course.
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }
}
