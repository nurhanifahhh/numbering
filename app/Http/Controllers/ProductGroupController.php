<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductGroupController extends Controller
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
        return view('pages.productGroup.index');
    }

    public function create()
    {
        $category = Category::all();
        $productGroup = ProductGroup::all();
        return view('pages.productGroup.create', compact(['productGroup', 'category']));
    }

    public function store(Request $request)
    {
        try {
            $saveGroup = ProductGroup::saveProductGroup($request);

            if ($saveGroup)
                return redirect()->route('dashboard.productgroup.create');
        } catch (Exception $e) {
            dd($e);
            DB::rollback();
        }
    }

    public function destroy($productGroup_id)
    {

        $document = ProductGroup::findOrFail($productGroup_id);
        $document->delete();

        $result['code'] = 200;
        // $result['data'] = $category->code . (substr($document->docNumber, -4) + 1);
        $result['message'] = "Berhasil menghapus data!";

        return response()->json($result, 200);
    }


    public function show($id)
    {
        $result = [];
        $result['code'] = 400;
        $result['message'] = "Data tidak di temukan!";


        $productDetail = ProductGroup::getProductGroupDetail($id);

        if ($productDetail->count() > 0) {
            $result['code'] = 200;
            $result['data'] = $productDetail;
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

        $productGroup = ProductGroup::findOrFail($id);
        if ($productGroup->count() > 0) {
            $productGroup->category_id = $data['category_id'];
            $productGroup->name = $data['name'];
            $productGroup->numberCode = $data['numberCode'];
            $productGroup->save();

            $result['code'] = 200;
            $result['message'] = "Berhasil mengubah data!";
            return response()->json($result, 200);
        }

        return response()->json($result, 400);
    }


    public function getProductGroupDatatable(Request $request)
    {
        $query =  ProductGroup::all();

        return DataTables::eloquent($query)->toJson();
    }
}
