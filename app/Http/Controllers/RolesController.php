<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:وظائف-بيانات|وظائف-اضافة|وظائف-تعديل|وظائف-حذف', ['only' => ['index']]);
        $this->middleware('permission:وظائف-اضافة', ['only' => ['create','store']]);
        $this->middleware('permission:وظائف-تعديل', ['only' => ['edit','update']]);
        $this->middleware('permission:وظائف-حذف', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $roles = Role::paginate(10);

        return view('roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('roles.add', ['permissions' => $permissions]);
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

            Role::create($request->all());

            DB::commit();
            return redirect()->route('roles.index')->with('success','تم انشاء الوظيفة بنجاح!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('roles.add')->with('error',$th->getMessage());
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
        $role = Role::whereId($id)->with('permissions')->first();

        $permissions = Permission::all();

        return view('roles.edit', ['role' => $role, 'permissions' => $permissions]);
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

            // Validate Request
            $request->validate([
                'name' => 'required',
                'guard_name' => 'required'
            ]);

            $role = Role::whereId($id)->first();

            $role->name = $request->name;
            $role->guard_name = $request->guard_name;
            $role->save();

            // Sync Permissions
            $permissions = $request->permissions;
            $role->syncPermissions($permissions);

            DB::commit();
            return redirect()->route('roles.index')->with('success','تم نعديل الصلاحية بنجاح!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('roles.edit',['role' => $role])->with('error',$th->getMessage());
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

            Role::whereId($id)->delete();

            DB::commit();
            return redirect()->route('roles.index')->with('success','تم حذف الصلاحية بنجاح!');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('roles.index')->with('error',$th->getMessage());
        }
    }
}
