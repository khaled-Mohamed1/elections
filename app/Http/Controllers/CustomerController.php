<?php

namespace App\Http\Controllers;

use App\Exports\AdverserExport;
use App\Exports\AllCustomersExport;
use App\Exports\CommittedExport;
use App\Exports\CustomerExport;
use App\Exports\CustomersExport;
use App\Helpers\Helper;
use App\Imports\CustomerImport;
use App\Models\Attachment;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\CustomerDraft;
use App\Models\CustomerIssue;
use App\Models\CustomerJob;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\TemplateProcessor;


class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:عملاء-بيانات|عملاء-اضافة|عملاء-تعديل|عملاء-حذف|عملاء-ملف-شخصي|عملاء-استراد', ['only' => ['index']]);
        $this->middleware('permission:عملاء-اضافة', ['only' => ['create','store']]);
        $this->middleware('permission:عملاء-تعديل', ['only' => ['edit','update']]);
        $this->middleware('permission:عملاء-حذف', ['only' => ['delete']]);
        $this->middleware('permission:عملاء-ملف-شخصي', ['only' => ['show']]);
        $this->middleware('permission:عملاء-المتعسرين', ['only' => ['indexAdverser']]);
        $this->middleware('permission:عملاء-الملتزمين', ['only' => ['indexCommitted']]);
        $this->middleware('permission:عملاء-المرفوضين', ['only' => ['indexRejected']]);
        $this->middleware('permission:عملاء-الجميع', ['only' => ['indexCustomers']]);
        $this->middleware('permission:عملاء-المهام', ['only' => ['indexTask','addTask']]);
        $this->middleware('permission:عملاء-المتابعة', ['only' => ['indexFollow','changeFollow']]);
        $this->middleware('permission:عملاء-استراد', ['only' => ['importCustomers','uploadCustomers']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */


    public function index()
    {
        $customers = Customer::orderBy('customer_NO','desc')->where('status','جديد')->paginate(100);
        return view('customers.index', ['customers' => $customers]);
    }

    public function indexCustomers()
    {
        $customers = Customer::orderBy('customer_NO','desc')->paginate(100);
        return view('customers.customers', ['customers' => $customers]);
    }

    public function indexAdverser()
    {
        $customers = Customer::orderBy('customer_NO','desc')->where('status','=','متعسر')->paginate(100);
        return view('customers.index_adverser', ['customers' => $customers]);
    }

    public function indexCommitted()
    {
        $customers = Customer::orderBy('customer_NO','desc')->where('status','=','ملتزم')->paginate(100);
        return view('customers.committed', ['customers' => $customers]);
    }

    public function indexRejected()
    {
        $customers = Customer::orderBy('customer_NO','desc')->where('status','=','مرفوض')->paginate(100);
        return view('customers.rejected', ['customers' => $customers]);
    }

    public function indexTask()
    {
        $users = User::where('role_id','!=','1')->where('role_id','!=','3')->latest()->get();
        $customers = Customer::orderBy('customer_NO','desc')->whereNull('updated_by')->where(function ($query){
            $query->where('status','=','متعسر')->orWhere('status','=','قيد التوقيع')
                ->orWhere('status','=','مقبول');
        })->paginate(100);
        return view('customers.tasks', ['customers' => $customers,'users'=>$users]);
    }

    public function indexFollow()
    {
        $customers = Customer::orderBy('customer_NO','desc')->where('repeater',true)->paginate(100);
        return view('customers.follow-up', ['customers' => $customers]);
    }

    public function changeFollow(Request $request): \Illuminate\Http\JsonResponse
    {
        if($request->repeater === 'true'){
            $customer = Customer::findOrFail($request->customer_id)->update([
                'status' => 'قيد التوقيع',
                'repeater' => 0,
            ]);
        }else{
            $customer = Customer::findOrFail($request->customer_id)->update([
                'status' => 'مرفوض',
                'repeater' => 0,
            ]);
        }


        return response()->json([
            'status' => 'success',
        ]);
    }



    public function addTask(Request $request)
    {

        if($request->user_id === 'false'){
            $customer = Customer::findOrFail($request->customer_id)->update([
                'updated_by' => NULL,
            ]);
        }else{
            $customer = Customer::findOrFail($request->customer_id)->update([
                'updated_by' => $request->user_id,
            ]);        }

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function addTaskIssue(Customer $customer,Request $request)
    {
        DB::beginTransaction();
        try {

            if($request->user_id === 'false'){
                $customer = Customer::findOrFail($customer->id)->update([
                    'updated_issue_by' => NULL,
                    'notes' => $request->notes
                ]);
                // Commit And Redirected To Listing
                DB::commit();
                return redirect()->back()->with('success','تم الغاء المهمة عن الموظف!');
            }else{
                $customer = Customer::findOrFail($customer->id)->update([
                    'updated_issue_by' => $request->user_id,
                    'notes' => $request->notes
                ]);

                // Commit And Redirected To Listing
                DB::commit();
                return redirect()->back()->with('success','تم انشاء اضافة المهمة للموظف بنجاح');
            }

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::latest()->get();
        $jobs = CustomerJob::latest()->get();
        return view('customers.add',
            [
                'banks' => $banks,
                'jobs' => $jobs,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'full_name'    => 'required',
            'ID_NO'     => 'required|numeric|digits:9',
            'phone_NO' => 'required|numeric|digits:10',
            'region'       =>  'required',
            'address'       =>  'required',
            'date_of_birth' =>  'required|date',
            'marital_status' =>  'required',
            'number_of_children' =>  'required',
            'job'   =>  'required',
            'salary'   =>  'required',
        ],[
                'full_name.required' => 'يجب ادخال اسم العميل',
                'ID_NO.required' => 'يجب ادخال رقم هوية العميل',
                'ID_NO.numeric' => 'يجب ادخال رقم الهوية بالأرقام',
                'ID_NO.digits' => 'رقم الهوية يتكون من 9 ارقام فقط',
                'phone_NO.required' => 'يجب ادخال رقم جوال العميل',
                'phone_NO.numeric' => 'يجب ادخال رقم الجوال بالأرقام',
                'phone_NO.digits' => 'رقم الجوال يتكون من 10 ارقام فقط',
                'region.required' => 'يجب ادخال منطفة السكن',
                'address.required' => 'يجب ادخال العنوان بالتفصيل',
                'date_of_birth.required' => 'يجب ادخال تاريخ ميلاد العميل',
                'marital_status.required' => 'يجب ادخال الحالة الإجتماعية للعميل',
                'number_of_children.required' => 'يجب ادخال عدد افراد الأسرة العميل',
                'job.required' => 'يجب ادخال الوظيفة العميل',
                'salary.required' => 'يجب ادخال دخل العميل',
            ]
        );



        DB::beginTransaction();
        try {

            $repeater_customer = Customer::where('ID_NO', $request->ID_NO)->first();
            if($repeater_customer !== null){
                $customer_updated = Customer::where('ID_NO', $request->ID_NO)->update([
                    'repeater' => true
                ]);

                DB::commit();
                return redirect()->route('home')->with('warning','العميل موجود مسبقا! يتم الأن مراجعته من قبل المدير.');
            }

            // Store Data
            $customer = Customer::create([
                'customer_NO' => Helper::IDGenerator(new Customer, 'customer_NO', 5,4),
                'full_name'    => $request->full_name,
                'ID_NO'     => $request->ID_NO,
                'phone_NO'         => $request->phone_NO,
                'region' => $request->region,
                'address'       => $request->address,
                'notes'       => $request->notes,
                'created_by' => auth()->user()->id,
                'reserve_phone_NO'    => $request->reserve_phone_NO,
                'date_of_birth'     => $request->date_of_birth,
                'marital_status'         => $request->marital_status,
                'number_of_children' => $request->number_of_children,
                'job_id'       => $request->job,
                'salary'       => $request->salary,
                'bank_id'       => $request->bank_name,
                'bank_branch'       => $request->bank_branch,
                'bank_account_NO'       => $request->bank_account_NO,
            ]);

            if($customer->customer_NO == 400000){
                $customer->customer_NO = $customer->customer_NO + 1;
                $customer->save();
            }

            $customer_id = $customer->id;


            if($request->hasFile('files')){
                $files = $request->file('files');

                foreach ($files as $file){
                    if ($file instanceof UploadedFile) {
                        $imageName = Str::random(32) . "." . $file->getClientOriginalExtension();

                        $customer = Attachment::create([
                            'customer_id' => $customer_id,
                            'user_id'    => auth()->user()->id,
                            'title'     => $file->getClientOriginalName(),
                            'attachment'         => 'https://sadaqa-co1.com/storage/app/public/attachments/' . $imageName,
                        ]);

                        Storage::disk('public')->put('attachments/' . $imageName, file_get_contents($file));
                    }

                }

            }

            DB::commit();


            // Commit And Redirected To Listing
            return redirect()->route('home')->with('success','تم انشاء العميل بنجاح');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return Application|Factory|View
     */
    public function show(Customer $customer)
    {
        $users_issues = User::where('role_id',13)->latest()->get();
        $users = User::where('role_id','!=','1')->where('role_id','!=','3')->latest()->get();
        $drafts = CustomerDraft::with('DraftCustomerDraft')->where('customer_id',$customer->id)->get();
        $issues = CustomerIssue::with('IssueCustomerIssue')->where('customer_id',$customer->id)->get();
        return view('customers.show')->with([
            'customer'  => $customer,
            'drafts' => $drafts,
            'issues' => $issues,
            'users' => $users,
            'users_issues' =>$users_issues
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $banks = Bank::latest()->get();
        $jobs = CustomerJob::latest()->get();
        return view('customers.edit')->with([
            'customer'  => $customer,
            'banks' => $banks,
            'jobs' => $jobs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function update(Request $request, Customer $customer)
    {


        // Validations
        $request->validate(
            [
                'full_name'    => 'required',
                'ID_NO'     => 'required|numeric|digits:9|'.Rule::unique('customers')->ignore($customer->id),
                'phone_NO' => 'required|numeric|digits:10',
                'region'       =>  'required',
                'address'       =>  'required',

                'date_of_birth' =>  'required|date',
                'marital_status' =>  'required',
                'number_of_children' =>  'required',
                'job'   =>  'required',
                'salary'   =>  'required',
            ],[
                'full_name.required' => 'يجب ادخال اسم العميل',
                'ID_NO.required' => 'يجب ادخال رقم هوية العميل',
                'ID_NO.unique' => 'تم ادخال رقم الهوية من قبل',
                'ID_NO.numeric' => 'يجب ادخال رقم الهوية بالأرقام',
                'ID_NO.digits' => 'رقم الهوية يتكون من 9 ارقام فقط',
                'phone_NO.required' => 'يجب ادخال رقم جوال العميل',
                'phone_NO.numeric' => 'يجب ادخال رقم الجوال بالأرقام',
                'phone_NO.digits' => 'رقم الجوال يتكون من 10 ارقام فقط',
                'region.required' => 'يجب ادخال منطفة السكن',
                'address.required' => 'يجب ادخال العنوان بالتفصيل',
                'date_of_birth.required' => 'يجب ادخال تاريخ ميلاد العميل',
                'marital_status.required' => 'يجب ادخال الحالة الإجتماعية للعميل',
                'number_of_children.required' => 'يجب ادخال عدد افراد الأسرة العميل',
                'job.required' => 'يجب ادخال الوظيفة العميل',
                'salary.required' => 'يجب ادخال دخل العميل',
            ]
        );

        DB::beginTransaction();
        try {

            // Store Data
            if($request->status == 'مقبول' || $request->status == 'قيد التوقيع'){
                $status = 'قيد التوقيع';
            }

            $customer_updated = Customer::whereId($customer->id)->update([
                'full_name'    => $request->full_name,
                'ID_NO'     => $request->ID_NO,
                'phone_NO'         => $request->phone_NO,
                'region' => $request->region,
                'address'       => $request->address,
                'status' => $status ?? $request->status,
                'account' => $request->account,
                'notes' => $request->notes,
                'reserve_phone_NO'    => $request->reserve_phone_NO,
                'date_of_birth'     => $request->date_of_birth,
                'marital_status'         => $request->marital_status,
                'number_of_children' => $request->number_of_children,
                'job_id'       => $request->job,
                'salary'       => $request->salary,
                'bank_id'       => $request->bank_name,
                'bank_branch'       => $request->bank_branch,
                'bank_account_NO'       => $request->bank_account_NO,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('customers.index')->with('success','تم تعديل العميل بنجاح!');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function delete(Customer $customer): RedirectResponse
    {
        DB::beginTransaction();
        try {
            // Delete User
            Customer::whereId($customer->id)->delete();

            DB::commit();
            return redirect()->route('customers.index')->with('success', 'تم حذف العميل بنجاح!');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function importCustomers()
    {
        return view('customers.import');
    }

    public function uploadCustomers(Request $request): RedirectResponse
    {
        $request->validate([
                'file'    => 'required',
            ]
            ,[
                'file.required' => 'يجب ادخال ملف اكسل',
            ]);

        Excel::import(new CustomerImport(), $request->file('file'));


        return redirect()->route('customers.index')->with('success', 'تم استيراد بيانات العملاء');
    }

    public function export(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new CustomersExport(), 'العملاء المقبولين.xlsx');
    }

    public function exportAdverser(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new AdverserExport(), 'المتعسرين.xlsx');
    }

    public function exportCustomers(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new AllCustomersExport(), 'جميع العملاء.xlsx');
    }

    public function exportCustomer(Customer $customer): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new CustomerExport($customer), 'العميل.xlsx');
    }

    public function exportCommitted(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new CommittedExport(), 'الملتزمين.xlsx');
    }

    public function search(Request $request)
    {
        if ($request->filled('search')) {
            $customers = Customer::query();
            if ($request->filled('search')) {
                $customers = $customers->where('ID_NO', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('customer_NO', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('full_name', 'LIKE', '%' . $request->search . '%');
            }
            $customers = $customers->get();

        } else {
            return redirect()->back();
        }
        return view('customers.search', compact('customers'));
    }

    public function exportWORD(Request $request){

        $data = Customer::findOrFail($request->customer_id);
        $drafts= $data->CustomerDrafts;
        $array_draft = array();
        foreach ($drafts as $row){
            $array_draft[] = $row->DraftCustomerDraft->draft_NO;
        }
        $str_draft = implode("- ",$array_draft);

        $issues= $data->CustomerIssues;
        $array_issue = array();
        $array_issue_name = array();
        foreach ($issues as $row){
            $array_issue[] = $row->IssueCustomerIssue->issue_NO;
            $array_issue_name[] = $row->IssueCustomerIssue->court_name;
        }
        $str_issue = implode("- ",$array_issue);
        $str_issue_name = implode("- ",$array_issue_name);

        $payments = $data->payments->toArray();

        $templateProcessor = new TemplateProcessor('wordOffice/customer.docx');
        $templateProcessor->setValue('customer_NO',$data->customer_NO);
        $templateProcessor->setValue('full_name',$data->full_name);
        $templateProcessor->setValue('ID_NO',$data->ID_NO);
        $templateProcessor->setValue('phone_NO',$data->phone_NO);
        $templateProcessor->setValue('region',$data->region);
        $templateProcessor->setValue('address',$data->address);
        $templateProcessor->setValue('reserve_phone_NO',$data->reserve_phone_NO);
        $templateProcessor->setValue('job',$data->CustomerJob->name);
        $templateProcessor->setValue('bank_name',$data->CustomerBank->name);
        $templateProcessor->setValue('bank_branch',$data->bank_branch);

        $parts = explode(",", $data->notes);
        $newString = implode("\n", $parts);

        $templateProcessor->setValue('notes',$newString);
        $templateProcessor->setValue('bank_account_NO',$data->bank_account_NO);
        $templateProcessor->setValue('drafts',$str_draft);
        $templateProcessor->setValue('issues',$str_issue);
        $templateProcessor->setValue('issues_name',$str_issue_name);

        $templateProcessor->cloneRowAndSetValues('payment_NO', $payments);
        $fileName = $data->customer_NO;
        $templateProcessor->saveAs($fileName.'.docx');
        return response()->download($fileName.'.docx')->deleteFileAfterSend(true);
    }


}
