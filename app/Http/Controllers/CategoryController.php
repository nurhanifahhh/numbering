<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.category.index');
    }

    public function create()
    {
        $category = Category::all();
        return view('pages.category.create', compact('category'));
    }

    public function store(Request $request)
    {
        try {
            $saveRoom = Category::saveCategory($request);

            if ($saveRoom)
                return redirect()->route('dashboard.category.create');
        } catch (Exception $e) {
            dd($e);
            DB::rollback();
        }
    }

    public function destroy(Category $category)
    {
        $result = [];
        $result['code'] = 400;
        $result['message'] = "Data tidak di temukan!";
        if ($category->delete()) {
            $result['message'] = "Berhasil menghapus category!";
            return response()->json($result, 200);
        }
        return response()->json($result, 400);
    }

    public function show($id)
    {
        $result = [];
        $result['code'] = 400;
        $result['message'] = "Data tidak di temukan!";


        $categoryDetail = Category::getCategoryDetail($id);

        if ($categoryDetail->count() > 0) {
            $result['code'] = 200;
            $result['data'] = $categoryDetail;
            $result['messages'] = "Berhasil mengambil data!";

            return response()->json($result, 200);
        }

        return response()->json($result, 400);
    }

    public function update(Request $request, $id)
    {
        $result = [];
        $result['code'] = 400;
        $result['message'] = "Data tidak di temukan!";


        $data = $request->all();

        $category = Category::findOrFail($id);
        if ($category->count() > 0) {
            $category->name = $data['name'];
            $category->code = $data['code'];
            $category->save();

            $result['code'] = 200;
            $result['message'] = "Berhasil mengubah data!";
            return response()->json($result, 200);
        }

        return response()->json($result, 400);
    }


    public function getCategoryDatatable(Request $request)
    {
        $query =  Category::all();

        return DataTables::eloquent($query)->toJson();
    }
}
