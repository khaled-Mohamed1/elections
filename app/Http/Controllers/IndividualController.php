<?php

namespace App\Http\Controllers;

use App\Models\Individual;
use App\Models\ElectoralCenter;
use App\Models\TeamLeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class IndividualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $individuals = Individual::latest()->paginate(100);
        return view(
            'individuals.index',
            ['individuals' => $individuals]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $electoralCenters = ElectoralCenter::latest()->get();
        $teamLeaders = TeamLeader::latest()->get();
        return view('individuals.create', with([
            'electoralCenters' => $electoralCenters,
            'teamLeaders' => $teamLeaders

        ]));
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
            'i_name' => 'required|string|max:255',
            'i_NO' => 'numeric|digits_between:10,13|unique:individuals,i_NO',
            'i_phone_NO' => 'required|numeric|digits:11',
            'address' => 'required|string|max:255',
            'electoral_id' => 'required',
            'team_leader_id' => 'required',
        ], [
            'i_name.required' => 'حقل الاسم مطلوب.',
            'i_name.string' => 'يجب أن يكون الاسم نصًا.',
            'i_name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',

            'i_NO.required' => 'حقل رقم الناخب مطلوب.',
            'i_NO.numeric' => 'يجب أن يكون رقم الناخب قيمة رقمية.',
            'i_NO.digits_between' => 'يجب أن يتكون رقم الناخب من 10 إلى 13 رقمًا.',
            'i_NO.unique' => 'تم ادخال رقم الناخب من قبل.',

            // 'i_phone_NO.required' => 'حقل رقم الهاتف الأول مطلوب.',
            'i_phone_NO.numeric' => 'يجب أن يكون رقم الهاتف الأول عددًا.',
            'i_phone_NO.digits' => 'يجب أن يتكون رقم الهاتف الأول من 11 رقمًا.',

            'address.required' => 'حقل عنوان السكن مطلوب.',
            'address.string' => 'يجب أن يكون عنوان السكن نصًا.',
            'address.max' => 'يجب ألا يتجاوز عنوان السكن 255 حرفًا.',

            'electoral_id.required' => 'يجب ادخال رقم مركز الإقتراع',
            'team_leader_id' => 'يجب ادخال اسم مسئول الفريق'
        ]);

        // return $request->all();

        // Validate the request
        DB::beginTransaction();
        try {

            // If the request is validated, create a new Individual instance and store it
            $individual = Individual::create([
                'i_name' => $request->i_name,
                'i_NO' => $request->i_NO,
                'address' => $request->address,
                'i_phone_NO' => $request->i_phone_NO,
                'electoral_id' => $request->electoral_id,
                'team_leader_id' => $request->team_leader_id,
                'user_id' => auth()->user()->id
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('individuals.index')->with('success', 'تم انشاء الناخب بنجاح');
        } catch (\Throwable $th) {

            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Individual  $individual
     * @return \Illuminate\Http\Response
     */
    public function show(Individual $individual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Individual  $individual
     * @return \Illuminate\Http\Response
     */
    public function edit(Individual $individual)
    {
        $electoralCenters = ElectoralCenter::latest()->get();
        $teamLeaders = TeamLeader::latest()->get();
        return view('individuals.edit', with([
            'individual' => $individual,
            'electoralCenters' => $electoralCenters,
            'teamLeaders' => $teamLeaders

        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Individual  $individual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Individual $individual)
    {
        // Validation rules
        $request->validate([
            'i_name' => 'required|string|max:255',
            'i_NO' => 'required|numeric|digits_between:10,13|'. Rule::unique('individuals')->ignore($individual->id) ,
            'i_phone_NO' => 'numeric|digits:11',
            'address' => 'required|string|max:255',
            'electoral_id' => 'required',
            'team_leader_id' => 'required',
        ], [
            'i_name.required' => 'حقل الاسم مطلوب.',
            'i_name.string' => 'يجب أن يكون الاسم نصًا.',
            'i_name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',

            'i_NO.required' => 'حقل رقم الناخب مطلوب.',
            'i_NO.numeric' => 'يجب أن يكون رقم الناخب قيمة رقمية.',
            'i_NO.digits_between' => 'يجب أن يتكون رقم الناخب من 10 إلى 13 رقمًا.',
            'i_NO.unique' => 'تم ادخال رقم الناخب من قبل!',

            // 'i_phone_NO.required' => 'حقل رقم الهاتف الأول مطلوب.',
            'i_phone_NO.numeric' => 'يجب أن يكون رقم الهاتف الأول عددًا.',
            'i_phone_NO.digits' => 'يجب أن يتكون رقم الهاتف الأول من 11 رقمًا.',

            'address.required' => 'حقل عنوان السكن مطلوب.',
            'address.string' => 'يجب أن يكون عنوان السكن نصًا.',
            'address.max' => 'يجب ألا يتجاوز عنوان السكن 255 حرفًا.',

            'electoral_id.required' => 'يجب ادخال رقم مركز الإقتراع',
            'team_leader_id' => 'يجب ادخال اسم مسئول الفريق'
        ]);

        // Validate the request
        DB::beginTransaction();
        try {

            // If the request is validated, update a new Individual instance and store it
            $individual = Individual::whereId($individual->id)->update([
                'i_name' => $request->i_name,
                'i_NO' => $request->i_NO,
                'address' => $request->address,
                'i_phone_NO' => $request->i_phone_NO,
                'electoral_id' => $request->electoral_id,
                'team_leader_id' => $request->team_leader_id,
                'user_id' => auth()->user()->id
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('individuals.index')->with('success', 'تم تعديل الناخب بنجاح');
        } catch (\Throwable $th) {

            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Individual  $individual
     * @return \Illuminate\Http\Response
     */
    public function delete(Individual $individual)
    {
        DB::beginTransaction();
        try {
            // Delete
            Individual::whereId($individual->id)->delete();

            DB::commit();
            return redirect()->route('individuals.index')->with('success', 'تم حذف الناخب بنجاح');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('search');

        $individuals = Individual::where('i_NO', 'LIKE', "%$query%")->get();

        return view('individuals.search', [
            'individuals' => $individuals,
        ]);
    }

    public function checkINO(Request $request)
    {
        $iNO = $request->input('i_NO');
        $exists = Individual::where('i_NO', $iNO)->exists();
        return response()->json(['exists' => $exists]);
    }

}
