<?php

namespace App\Http\Controllers\API\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
            $categories = Category::orderBy('slug')->paginate(10);
            return response()->json($categories, JsonResponse::HTTP_OK);

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
    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->all();
            $category = new \App\Category();
            $category->fill($data);
            $category->save();
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
            $category = Category::findOrFail($id);
            return response()->json($category, JsonResponse::HTTP_OK);

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
            $category = Category::findOrFail($id);
            $category->update($data);
            return response()->json(['message' => 'successfully updated'], JsonResponse::HTTP_OK);

        }catch (ModelNotFoundException $e) {
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
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json(['message' => 'successfully deleted'], JsonResponse::HTTP_OK);
        }catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Model dont\t existe'], JsonResponse::HTTP_CONFLICT);

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }
}
