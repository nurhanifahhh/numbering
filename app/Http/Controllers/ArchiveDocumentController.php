<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\ProductGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Exception;

class ArchiveDocumentController extends Controller
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
        $document = Document::all();
        return view('pages.archive.index', compact('document'));
    }

    public function create()
    {
        $category = Category::all();
        $productGroup = ProductGroup::all();
        return view('pages.archive.createDocument', compact(['category', 'productGroup']));
    }

    public function storeDocument(Request $request)
    {
        $result = [];
        $result['code'] = 400;

        try {
            $data = $request->all();
            $fileDocument = $request->file('fileDocument');
            $fileName = time() . "_" . $fileDocument->getClientOriginalName();
            $uploadFolder = 'fileDocument';
            $fileDocument->move($uploadFolder, $fileName);

            $saveDocument = new Document();
            $saveDocument->category_id = $data['category_id'];
            $saveDocument->product_group_id = $data['product_group_id'];
            $saveDocument->docNumber = $data['docNumber'];
            $saveDocument->judul = $data['judul'];
            $saveDocument->edisi = $data['edisi'];
            $saveDocument->originator = $data['originator'];
            $saveDocument->fileDocument = $fileName;
            $saveDocument->save();

            return redirect()->route('dashboard.archive.index');
        } catch (Exception $e) {

            dd($e);
            DB::rollback();
        }
    }

    public function getProductByCategoryId($category_id)
    {
        $result = [];
        $result['code'] = 400;
        $result['message'] = "Data Product Kosong!";

        $product = ProductGroup::where('category_id', $category_id)->get();

        if ($product->count() > 0) {
            $result['code'] = 200;
            $result['data'] = $product;
            $result['messages'] = "Berhasil mengambil data!";

            return response()->json($result, 200);
        }

        return response()->json($result, 400);
    }

    public function generateDocNumber($category_id, $product_id)
    {
        $result = [];
        $result['code'] = 400;
        $result['message'] = "Data tidak di temukan!";


        $category = Category::findOrFail($category_id);
        $productGroup = ProductGroup::findOrFail($product_id);
        $document = Document::where(['category_id' => $category_id, 'product_group_id' => $product_id])->latest()->first();


        if ($document != null) {
            $result['code'] = 200;
            $result['data'] = $category->code . (substr($document->docNumber, -4) + 1);
            $result['messages'] = "Berhasil mengambil data!";

            return response()->json($result, 200);
        } else {
            $result['code'] = 200;
            $result['data'] = $category->code . $productGroup->numberCode;
            $result['message'] = "Berhasil mengambil data!";

            return response()->json($result, 200);
        }

        return response()->json($result, 400);
    }

    public function deleteDocument($document_id)
    {
        $document = Document::findOrFail($document_id);
        File::delete("fileDocument/" . $document->fileDocument);
        
        $document->delete();

        $result['code'] = 200;
        // $result['data'] = $category->code . (substr($document->docNumber, -4) + 1);
        $result['message'] = "Berhasil menghapus data!";

        return response()->json($result, 200);
        // return redirect()->route('dashboard.archive.index');
    }

    public function edit($document_id)
    {
        $document = Document::with(['category', 'productGroup'])->find($document_id);
        $category = Category::all();

        return view('pages.archive.editDocument', compact(['document', 'category']));
    }

    public function updateDocument(Request $request)
    {
        $result = [];
        $result['code'] = 400;

        try {

            $data = $request->all();
            $fileDocument = $request->file('fileDocument');

            $document = Document::findOrFail($data['document_id']);

            if (!empty($fileDocument)) {
                File::delete("fileDocument/" . $document->fileDocument);
                $fileName = time() . "_" . $fileDocument->getClientOriginalName();
                $uploadFolder = 'fileDocument';
                $fileDocument->move($uploadFolder, $fileName);
    
                $document->fileDocument = $fileName;
            }
            // $document->category_id = $data['category_id'];
            // $document->product_group_id = $data['product_group_id'];
            // $document->docNumber = $data['docNumber'];
            $document->judul = $data['judul'];
            $document->edisi = $data['edisi'];
            $document->originator = $data['originator'];
            $document->save();

            return redirect()->route('dashboard.archive.index');
        } catch (Exception $e) {

            dd($e);
            DB::rollback();
        }
    }
}
