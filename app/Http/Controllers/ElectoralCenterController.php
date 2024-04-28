<?php

namespace App\Http\Controllers;

use App\Models\ElectoralCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ElectoralCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $electoralCenters = ElectoralCenter::latest()->paginate(100);
        return view(
            'electoralCenters.index',
            ['electoralCenters' => $electoralCenters]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('electoralCenters.create');
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
            'ec_name' => 'required|string|max:255',
            'ec_NO' => 'required|numeric',
            // 'ec_NO' => 'required|numeric|digits_between:10,12',
        ], [
            'ec_name.required' => 'حقل اسم مركز الإقتراع مطلوب.',
            'ec_name.string' => 'يجب أن يكون اسم مركز الإقتراع نصًا.',
            'ec_name.max' => 'يجب ألا يتجاوز اسم مركز الإقتراع 255 حرفًا.',

            'ec_NO.required' => 'حقل رقم مركز الإقتراع مطلوب.',
            'ec_NO.numeric' => 'يجب أن يكون رقم مركز الإقتراع الأول قيمة رقمية.',
            // 'ec_NO.digits_between' => 'يجب أن يحتوي رقم الهاتف الأول على 10 إلى 12 رقمًا.',
        ]);

        // Validate the request
        DB::beginTransaction();
        try {

            // If the request is validated, create a new ElectoralCenter instance and store it
            $electoralCenter = ElectoralCenter::create([
                'ec_name' => $request->ec_name,
                'ec_NO' => $request->ec_NO,
                'user_id' => auth()->user()->id
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('electoralCenters.index')->with('success', 'تم انشاء مركز الإنتخاب بنجاح');
        } catch (\Throwable $th) {

            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ElectoralCenter  $electoralCenter
     * @return \Illuminate\Http\Response
     */
    public function show(ElectoralCenter $electoralCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ElectoralCenter  $electoralCenter
     * @return \Illuminate\Http\Response
     */
    public function edit(ElectoralCenter $electoralCenter)
    {
        return view('electoralCenters.edit', with([
            'electoralCenter' => $electoralCenter,
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ElectoralCenter  $electoralCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ElectoralCenter $electoralCenter)
    {
        // Validation rules
        $request->validate([
            'ec_name' => 'required|string|max:255',
            'ec_NO' => 'required|numeric',
            // 'ec_NO' => 'required|numeric|digits_between:10,12',
        ], [
            'ec_name.required' => 'حقل اسم مركز الإقتراع مطلوب.',
            'ec_name.string' => 'يجب أن يكون اسم مركز الإقتراع نصًا.',
            'ec_name.max' => 'يجب ألا يتجاوز اسم مركز الإقتراع 255 حرفًا.',

            'ec_NO.required' => 'حقل رقم مركز الإقتراع مطلوب.',
            'ec_NO.numeric' => 'يجب أن يكون رقم مركز الإقتراع الأول قيمة رقمية.',
            // 'ec_NO.digits_between' => 'يجب أن يحتوي رقم الهاتف الأول على 10 إلى 12 رقمًا.',
        ]);

        // Validate the request
        DB::beginTransaction();
        try {

            // If the request is validated, update a new ElectoralCenter instance and store it
            $electoralCenter = ElectoralCenter::whereId($electoralCenter->id)->update([
                'ec_name' => $request->el_name,
                'ec_NO' => $request->el_NO,
                'user_id' => auth()->user()->id
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('electoralCenters.index')->with('success', 'تم تعديل مركز الإنتخاب بنجاح');
        } catch (\Throwable $th) {

            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ElectoralCenter  $electoralCenter
     * @return \Illuminate\Http\Response
     */
    public function delete(ElectoralCenter $electoralCenter)
    {
        DB::beginTransaction();
        try {
            // Delete
            ElectoralCenter::whereId($electoralCenter->id)->delete();

            DB::commit();
            return redirect()->route('electoralCenters.index')->with('success', 'تم حذف مركز الإنتخاب بنجاح');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function get(Request $request)
    {
        // Retrieve the ID of the electoral center from the request
        $electoralCenterId = $request->input('id');

        // Retrieve the electoral center from the database based on its ID
        $electoralCenter = ElectoralCenter::find($electoralCenterId);

        // If electoral center is found, return its name
        if ($electoralCenter) {
            return response()->json(['name' => $electoralCenter->ec_name]);
        }

        // If electoral center is not found, return an error message
        return response()->json(['error' => 'Electoral center not found'], 404);
    }

}
