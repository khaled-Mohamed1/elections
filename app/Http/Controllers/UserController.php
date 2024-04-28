<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:موظفين-بيانات|موظفين-اضافة|موظفين-تعديل|موظفين-حذف', ['only' => ['index']]);
        $this->middleware('permission:موظفين-اضافة', ['only' => ['create','store', 'updateStatus']]);
        $this->middleware('permission:موظفين-تعديل', ['only' => ['edit','update']]);
        $this->middleware('permission:موظفين-حذف', ['only' => ['delete']]);
    }


    /**
     * List User
     * @param Nill
     * @return Application|Factory|View
     * @author Shani Singh
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('users.index', ['users' => $users]);
    }

    /**
     * Create User
     * @param Nill
     * @return Application|Factory|View
     * @author Shani Singh
     */
    public function create()
    {
        $roles = Role::all();

        return view('users.add', ['roles' => $roles]);
    }

    public function show(User $user){
        return view('users.show')->with([
            'user'  => $user,
        ]);
    }


    /**
     * Store User
     * @param Request $request
     * @return RedirectResponse Users
     * @author Shani Singh
     */
    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|unique:users,email',
            'mobile_number' => 'required|numeric|digits:10',
            'role_id'       =>  'required|exists:roles,id',
            'status'       =>  'required|numeric|in:0,1',
            'income'       =>  'numeric',
        ]);

        DB::beginTransaction();
        try {

            // Store Data
            $user = User::create([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'mobile_number' => $request->mobile_number,
                'role_id'       => $request->role_id,
                'status'        => $request->status,
                'password'      => Hash::make($request->password),
                'not_hash_password' => $request->password,
                'income' => $request->income
            ]);

            // Delete Any Existing Role
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();

            // Assign Role To User
            $user->assignRole($user->role_id);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('users.index')->with('success','تم انشاء الموظف بنجاح!');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Update Status Of User
     * @param Integer $status
     * @return RedirectResponse Page With Success
     * @author Shani Singh
     */
    public function updateStatus($user_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'user_id'   => $user_id,
            'status'    => $status
        ], [
            'user_id'   =>  'required|exists:users,id',
            'status'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if($validate->fails()){
            return redirect()->route('users.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            User::whereId($user_id)->update(['status' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('users.index')->with('success','تم تغيير حالة الموظف بنجاح!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Edit User
     * @param Integer $user
     * @return Application|Factory|View
     * @author Shani Singh
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit')->with([
            'roles' => $roles,
            'user'  => $user
        ]);
    }

    /**
     * Update User
     * @param Request $request, User $user
     * @return RedirectResponse Users
     * @author Shani Singh
     */
    public function update(Request $request, User $user)
    {
        // Validations
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|unique:users,email,'.$user->id.',id',
            'mobile_number' => 'required|numeric|digits:10',
            'role_id'       =>  'required|exists:roles,id',
            'status'       =>  'required|numeric|in:0,1',
            'income'       =>  'numeric',

        ]);

        DB::beginTransaction();
        try {

            // Store Data
            $user_updated = User::whereId($user->id)->update([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'mobile_number' => $request->mobile_number,
                'role_id'       => $request->role_id,
                'status'        => $request->status,
                'income' => $request->income
            ]);

            if(isset($request->password)){
                $user_updated = User::whereId($user->id)->update([
                    'password'      => Hash::make($request->password),
                    'not_hash_password' => $request->password,
                ]);
            }

            // Delete Any Existing Role
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();

            // Assign Role To User
            $user->assignRole($user->role_id);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('users.index')->with('success','تم تعديل الموظف بنجاح');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Delete User
     * @param User $user
     * @return RedirectResponse Users
     * @author Shani Singh
     */
    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            // Delete User
            User::whereId($user->id)->delete();

            DB::commit();
            return redirect()->route('users.index')->with('success', 'تم حذف الموظف بنجاح!');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

}
