<?php

namespace App\Http\Controllers\API\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
            $courses = Course::orderBy('slug')->paginate(10);
            return response()->json($courses, JsonResponse::HTTP_OK);

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        try {
            $data = $request->all();
            $course = new \App\Course();
            $course->fill($data);
            $course->save();
            return response()->json( ['message' => 'successfully added'],JsonResponse::HTTP_OK);

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $course = Course::findOrFail($id);
            return response()->json($course, JsonResponse::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Model dont\t existe'], JsonResponse::HTTP_CONFLICT);

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $course = Course::findOrFail($id);
            $course->update($data);
            return response()->json(['message' => 'successfully updated'], JsonResponse::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Model dont\t existe'], JsonResponse::HTTP_CONFLICT);

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();
            return response()->json(['message' => 'successfully deleted'], JsonResponse::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Model dont\t existe'], JsonResponse::HTTP_CONFLICT);

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }
}
