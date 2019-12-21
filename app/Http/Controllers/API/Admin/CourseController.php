<?php

namespace App\Http\Controllers\API\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $courses = Course::orderBy('slug')->with(['image' => function ($query) {
                $query->select('*', DB::raw("CONCAT('" . Storage::disk('public')->url('images/courses/') . "', file_name) AS url"));
            }])->with(['category' => function ($query) {
                $query->with(['image' => function ($query) {
                    $query->select('*', DB::raw("CONCAT('" . Storage::disk('public')->url('images/categories/') . "', file_name) AS url"));
                }]);
            }])
                ->paginate(10);

            return response()->json(['status' => 'success', 'message' => 'Courses indexed successfully!', 'courses' => $courses], JsonResponse::HTTP_OK);

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        try {
            $data = $request->all();
            $course = new \App\Course();
            $course->fill($data);
            $course->save();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('courses', $file, $filename);
                $image = new Image();
                $image->file_name = $filename;
                $course->image()->save($image);
            }

            return response()->json(['status' => 'success', 'message' => 'Courses add successfully!'], JsonResponse::HTTP_OK);

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            $course = Course::where('slug', $slug)->first();

            if ($course) {
                return response()->json(['status' => 'success', 'message' => 'Course retrieved successfully!', 'course' => $course], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['message' => 'Model dont existe'], JsonResponse::HTTP_CONFLICT);
            }

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        try {
            $data = $request->all();
            $course = Course::where('slug', $slug)->first();
            $course->update($data);
            if ($course) {
                $course->update($data);

                if ($request->hasFile('image')) {
                    Storage::disk('public')->delete('courses/' . $course->image->file_name);
                    $course->image()->delete();
                    $file = $request->file('image');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('courses', $file, $filename);
                    $image = new Image();
                    $image->file_name = $filename;
                    $course->image()->save($image);
                }

                return response()->json(['status' => 'success', 'message' => 'Course updated successfully!', 'course' => $course], JsonResponse::HTTP_OK);

            } else {
                return response()->json(['message' => 'Model dont existe'], JsonResponse::HTTP_CONFLICT);
            }
        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $course = Course::where('slug', $id)->first();
            if ($course) {
                $course->delete();
                return response()->json(['status' => 'success', 'message' => 'Course deleted successfully!'], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['message' => 'Model dont existe'], JsonResponse::HTTP_CONFLICT);
            }
        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }
}
