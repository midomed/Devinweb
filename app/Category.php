<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\JsonResponse;
class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','slug'];

    /**
     * Get the user's image.
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
            if($this->image){
                Storage::disk('public')->delete('categories/'.$this->image->file_name);
                $this->image()->delete();
            }

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }


    /**
     * Get the courses for the category.
     */
    public function courses()
    {
        return $this->hasMany('App\Course', 'category_id');
    }
}
