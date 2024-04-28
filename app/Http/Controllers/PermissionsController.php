<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:صلاحيات-بيانات|صلاحيات-اضافة|صلاحيات-تعديل|صلاحيات-حذف', ['only' => ['index']]);
        $this->middleware('permission:صلاحيات-اضافة', ['only' => ['create','store']]);
        $this->middleware('permission:صلاحيات-تعديل', ['only' => ['edit','update']]);
        $this->middleware('permission:صلاحيات-حذف', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $permissions = Permission::paginate(10);

        return view('permissions.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'guard_name' => 'required'
            ]);

            Permission::create($request->all());

            DB::commit();
            return redirect()->route('permissions.index')->with('success','تم انشاء الصلاحية بنجاح!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('permissions.create')->with('error',$th->getMessage());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::whereId($id)->first();

        return view('permissions.edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'guard_name' => 'required'
            ]);

            $permission = Permission::whereId($id)->first();

            $permission->name = $request->name;
            $permission->guard_name = $request->guard_name;
            $permission->save();


            DB::commit();
            return redirect()->route('permissions.index')->with('success','تم تعديل الصلاحية بنجاح');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('permissions.edit',['permission' => $permission])->with('error',$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            Permission::whereId($id)->delete();

            DB::commit();
            return redirect()->route('permissions.index')->with('success','تم حذف الصلاحية بنجاح');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('permissions.index')->with('error',$th->getMessage());
        }
    }
}
