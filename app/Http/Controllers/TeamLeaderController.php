<?php

namespace App\Http\Controllers;

use App\Models\TeamLeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamLeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teamLeaders = TeamLeader::with("individuals")->latest()->paginate(100);
        return view(
            'teamLeaders.index',
            ['teamLeaders' => $teamLeaders]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teamLeaders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validation rules
        $request->validate([
            'tl_name' => 'required|string|max:255',
            // 'tl_team_name' => 'required|string|max:255',
            'tl_phone_NO1' => 'required|numeric|digits:11',
            'tl_phone_NO2' => 'nullable|numeric|digits:11',
            'address' => 'required|string|max:255',
        ], [
            'tl_name.required' => 'حقل الاسم المسئول مطلوب.',
            'tl_name.string' => 'يجب أن يكون الاسم نصًا.',
            'tl_name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',

            // 'tl_team_name.required' => 'حقل اسم الفريق مطلوب.',
            // 'tl_team_name.string' => 'يجب أن يكون اسم الفريق نصًا.',
            // 'tl_team_name.max' => 'يجب ألا يتجاوز اسم الفريق 255 حرفًا.',

            'tl_phone_NO1.required' => 'حقل رقم الهاتف الأول مطلوب.',
            'tl_phone_NO1.numeric' => 'يجب أن يكون رقم الهاتف الأول عددًا.',
            'tl_phone_NO1.digits' => 'يجب أن يتكون رقم الهاتف الأول من 11 رقمًا.',

            'tl_phone_NO2.numeric' => 'يجب أن يكون رقم الهاتف الثاني عددًا.',
            'tl_phone_NO2.digits' => 'يجب أن يتكون رقم الهاتف الثاني من 11 رقمًا.',

            'address.required' => 'حقل عنوان السكن مطلوب.',
            'address.string' => 'يجب أن يكون عنوان السكن نصًا.',
            'address.max' => 'يجب ألا يتجاوز عنوان السكن 255 حرفًا.',
        ]);

        // Validate the request
        DB::beginTransaction();
        try {

            // If the request is validated, create a new TeamLeader instance and store it
            $teamLeader = TeamLeader::create([
                'tl_name' => $request->tl_name,
                // 'tl_team_name' => $request->tl_team_name,
                'tl_phone_NO1' => $request->tl_phone_NO1,
                'tl_phone_NO2' => $request->tl_phone_NO2,
                'address' => $request->address,
                'user_id' => auth()->user()->id
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('teamLeaders.index')->with('success', 'تم انشاء المسئول بنجاح');
        } catch (\Throwable $th) {

            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeamLeader  $teamLeader
     * @return \Illuminate\Http\Response
     */
    public function show(TeamLeader $teamLeader)
    {


        return view('teamLeaders.show', with([
            'teamLeader' => $teamLeader,
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TeamLeader  $teamLeader
     * @return \Illuminate\Http\Response
     */
    public function edit(TeamLeader $teamLeader)
    {
        return view('teamLeaders.edit')->with([
            'teamLeader'  => $teamLeader,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeamLeader  $teamLeader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamLeader $teamLeader)
    {
        // Validation rules
        $request->validate([
            'tl_name' => 'required|string|max:255',
            // 'tl_team_name' => 'required|string|max:255',
            'tl_phone_NO1' => 'required|numeric|digits:11',
            'tl_phone_NO2' => 'nullable|numeric|digits:11',
            'address' => 'required|string|max:255',
        ], [
            'tl_name.required' => 'حقل الاسم المسئول مطلوب.',
            'tl_name.string' => 'يجب أن يكون الاسم نصًا.',
            'tl_name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',

            // 'tl_team_name.required' => 'حقل اسم الفريق مطلوب.',
            // 'tl_team_name.string' => 'يجب أن يكون اسم الفريق نصًا.',
            // 'tl_team_name.max' => 'يجب ألا يتجاوز اسم الفريق 255 حرفًا.',

            'tl_phone_NO1.required' => 'حقل رقم الهاتف الأول مطلوب.',
            'tl_phone_NO1.numeric' => 'يجب أن يكون رقم الهاتف الأول عددًا.',
            'tl_phone_NO1.digits' => 'يجب أن يتكون رقم الهاتف الأول من 11 رقمًا.',

            'tl_phone_NO2.numeric' => 'يجب أن يكون رقم الهاتف الثاني عددًا.',
            'tl_phone_NO2.digits' => 'يجب أن يتكون رقم الهاتف الثاني من 11 رقمًا.',

            'address.required' => 'حقل عنوان السكن مطلوب.',
            'address.string' => 'يجب أن يكون عنوان السكن نصًا.',
            'address.max' => 'يجب ألا يتجاوز عنوان السكن 255 حرفًا.',
        ]);

        // Validate the request
        DB::beginTransaction();
        try {

            // If the request is validated, update a new TeamLeader instance and store it
            $teamLeader = TeamLeader::whereId($teamLeader->id)->update([
                'tl_name' => $request->tl_name,
                // 'tl_team_name' => $request->tl_team_name,
                'tl_phone_NO1' => $request->tl_phone_NO1,
                'tl_phone_NO2' => $request->tl_phone_NO2,
                'address' => $request->address,
                'user_id' => auth()->user()->id
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('teamLeaders.index')->with('success', 'تم تعديل المسئول بنجاح');
        } catch (\Throwable $th) {

            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeamLeader  $teamLeader
     * @return \Illuminate\Http\Response
     */
    public function delete(TeamLeader $teamLeader)
    {
        DB::beginTransaction();
        try {
            // Delete
            TeamLeader::whereId($teamLeader->id)->delete();

            DB::commit();
            return redirect()->route('teamLeaders.index')->with('success', 'تم حذف المسئول بنجاح');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('search');

        $teamLeaders = TeamLeader::where('tl_name', 'LIKE', "%$query%")->get();

        return view('teamLeaders.search', [
            'teamLeaders' => $teamLeaders,
        ]);

    }

}
