<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    private function deleteAttachedImage()
    {
        try {
            $catgory_img = Image::where('imageable_type','course')->where('imageable_id',$this->id);
            $image = $catgory_img->file_name;
            if (!empty($image)) {
                File::delete(ImgUploader::real_public_path()  . $image);
                File::delete(ImgUploader::real_public_path()  . $image);
                File::delete(ImgUploader::real_public_path() . $image);
                $catgory_img->delete();
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Model dont\t existe'], JsonResponse::HTTP_CONFLICT);
        }
    }
}
