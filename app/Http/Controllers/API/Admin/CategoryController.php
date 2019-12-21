<?php

namespace App\Http\Controllers\API\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::orderBy('slug')->with(['image' => function ($query) {
                $query->select('*', DB::raw("CONCAT('" . Storage::disk('public')->url('images/categories/') . "', file_name) AS url"));
            }])->paginate(10);
            return response()->json(['status' => 'success', 'message' => 'Categories indexed successfully!', 'categories' => $categories], JsonResponse::HTTP_OK);

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
    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->all();
            $category = new \App\Category();
            $category->fill($data);
            $category->save();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('categories', $file, $filename);
                $image = new Image();
                $image->file_name = $filename;
                $category->image()->save($image);
            }

            return response()->json(['status' => 'success', 'message' => 'Categories add successfully!'], JsonResponse::HTTP_OK);

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
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                return response()->json(['status' => 'success', 'message' => 'Category retrieved successfully!', 'category' => $category], JsonResponse::HTTP_OK);
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
    public function update(CategoryRequest $request, $slug)
    {
        try {
            $data = $request->all();
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $category->update($data);

                if ($request->hasFile('image')) {
                    Storage::disk('public')->delete('categories/' . $category->image->file_name);
                    $category->image()->delete();
                    $file = $request->file('image');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('categories', $file, $filename);
                    $image = new Image();
                    $image->file_name = $filename;
                    $category->image()->save($image);
                }

                return response()->json(['status' => 'success', 'message' => 'Category updated successfully!', 'category' => $category], JsonResponse::HTTP_OK);

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
    public function destroy($slug)
    {
        try {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $category->delete();
                return response()->json(['status' => 'success', 'message' => 'Category deleted successfully!'], JsonResponse::HTTP_OK);
            } else {
                return response()->json(['message' => 'Model dont existe'], JsonResponse::HTTP_CONFLICT);
            }

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }
}
