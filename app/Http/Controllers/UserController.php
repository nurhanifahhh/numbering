<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.user.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = [];
        $result['code'] = 400;

        $validation = Validator::make($request->all(), User::$rules, User::$messages);

        if (!$validation->fails()) {
            $saveUser = User::saveUser($validation->validated());

            if ($saveUser) {
                $result['message'] = "Berhasil mendaftarkan user!";
                return response()->json($result, 200);
            }
        }


        $result['message'] = "{$validation->errors()->first()}";
        return response()->json($result, 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = [];
        $result['code'] = 400;
        $result['message'] = "Data tidak di temukan!";


        $userDetail = User::getUserDetail($id);

        if ($userDetail->count() > 0) {
            $result['code'] = 200;
            $result['data'] = $userDetail;
            $result['messages'] = "Berhasil mengambil data!";

            return response()->json($result, 200);
        }

        return response()->json($result, 400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $result = [];
        $result['code'] = 400;

        $validation = Validator::make($request->all(), User::$updateRules, User::$updateMessages);

        if (!$validation->fails()) {
            $saveUser = User::updateUser($validation->validated(), $id);

            if ($saveUser) {
                $result['message'] = "Berhasil mengupdate user!";
                return response()->json($result, 200);
            }
        }


        $result['message'] = "{$validation->errors()->first()}";
        return response()->json($result, 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            $result['message'] = "Berhasil menghapus akun!";
            return response()->json($result, 200);
        }
    }

    public function getUserDatatable(Request $request)
    {

        $query =  User::with('roles')->select("users.*")
            ->whereHas('roles', function ($query) {
                return $query->where('name', '!=', 'Super Admin');
            });


        return DataTables::eloquent($query)
            ->addColumn('roles', function ($query) {
                return $query->getRoleNames()->first();
            })
            ->make(true);
    }

    
    public function setting()
    {
        return view("pages.user.setting");
    }
}
