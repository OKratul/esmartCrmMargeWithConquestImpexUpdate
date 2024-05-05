<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AssignReq;
use App\Models\AssignTask;
use App\Models\CrmAdmin;
use App\Models\CustomerModel;
use App\Models\Expanse;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Query;
use App\Models\QueryStatus;
use App\Models\Quotation;
use App\Models\User;
use App\Models\UserActivityLog;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;

//use Jenssegers\Agent\Facades\Agent;

class AdminDashboardController extends Controller
{

    public function dashboard() {


        $pageTitle = 'Admin Dashboard';

        $queryDateForm = \request('query_date_form');
        $queryDateTo = \request('query_date_to');
        $queryStatus = \request('status');

        $paymentDateTo = \request('payment_date_to');
        $paymentDateForm = \request('payment_date_form');

        $salesDateForm = \request('sales_date_form');
        $salesDateTo = \request('sales_date_to');

        $expenseDateForm = \request('expense_date_form');
        $expenseDateTo = \request('expense_date_to');


        $today = Carbon::now()->format('Y-m-d');
        $users = User::with(['attendances' => function ($query) use ($today) {
            $query->whereDate('login_time', $today)
                ->orderBy('login_time', 'asc')->first();
        }])->get();


//      ===== Query Search code ======
        if (!empty($queryDateForm) && !empty($queryDateTo)){
            $queries = Query::with('users','customers','notes')
                                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                                ->orderByDesc('created_at')
                                ->paginate(7)->withQueryString();

            $pendingQuery = Query::with('users','customers')
                                    ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                                    ->where('user_id',null)->get();
            $processingQuery = Query::with('users','customers')
                            ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                            ->where('status','Processing')->get();
            $assignQuery = Query::with('users','customers')
                                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                                ->where('user_id',!null)->get();
            $quotationSent = Query::with('users','customers')
                                    ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                                    ->where('status','Quotation Sent')->get();
            $closedQuery = Query::whereBetween('created_at',[$queryDateForm,$queryDateTo])->where('status','Closed')->get();

        }elseif(!empty($queryStatus)){
            $queries = Query::with('users','customers','notes')->
                            where('status', $queryStatus)->orderByDesc('created_at')
                            ->paginate(7)->withQueryString();

            $pendingQuery = Query::where('user_id',null)->get();
            $processingQuery = Query::where('status','Processing')->get();
            $assignQuery = Query::where('user_id',!null)->get();
            $quotationSent = Query::where('status','Quotation Sent')->get();
            $closedQuery = Query::where('status','Closed')->get();

            if ($queryStatus == 'Pending'){
                $queries = Query::where('user_id', null)->paginate(7)->withQueryString();
            }

        }
        else{
            $queries = Query::with('users','customers','notes')
                            ->orderByDesc('created_at')
                            ->paginate(7)->withQueryString();

            $pendingQuery = Query::where('user_id',null)->count();
            $processingQuery = Query::where('status','Processing')->get();
            $assignQuery = Query::where('user_id',!null)->get();
            $quotationSent = Query::where('status','Quotation Sent')->get();
            $closedQuery = Query::where('status','Closed')->get();

        }

        $users = User::all();

        if(!empty($queryDateForm && $queryDateTo)){
            $pendingQuery = Query::where('user_id',null)
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->count();
            $processingQuery = Query::where('status','Processing')
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->count();
            $quotationSent = Query::where('status','Quotation Sent')
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->count();
            $orderConfirmed = Query::where('status','Order Confirmed')
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->count();
            $deliveryOnGoing = Query::where('status','Delivery On Going')
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->count();
            $delivered = Query::where('status','Delivered')
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->count();
            $closed = Query::where('status','Closed')
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->count();
        }else{
            $pendingQuery = Query::where('user_id',null)->count();
            $processingQuery = Query::where('status','Processing')->count();
//        $processingQuery = Query::where('status','Processing')->count();
            $quotationSent = Query::where('status','Quotation Sent')->count();
            $orderConfirmed = Query::where('status','Order Confirmed')->count();
            $deliveryOnGoing = Query::where('status','Delivery On Going')->count();
            $delivered = Query::where('status','Delivered')->count();
            $closed = Query::where('status','Closed')->count();
        }

        $counts = [$processingQuery, $quotationSent, $orderConfirmed, $deliveryOnGoing,$delivered,$closed];

        $queryStatus = QueryStatus::get('query_status');

        $statusCounts = $queryStatus->map(function ($status, $index) use ($counts) {
            return [
                'statusName' => $status->query_status,
                'count' => $counts[$index], // Use $index to get the corresponding count for each status
            ];
        })->toArray();


        if (!empty($paymentDateForm) && !empty($paymentDateTo)){

            $payments = Payment::whereBetween('created_at',[$paymentDateForm,$paymentDateTo])
                ->with('customers','invoices')
                ->orderByDesc('created_at')
                ->paginate(5)
                ->withQueryString();

        }else{
            $payments = Payment::
                    orderByDesc('created_at')
                 ->paginate(5)
                 ->withQueryString();
        }

        $overAllProcessingQuery = count(Query::where('status','Processing')->get());


        $admins = CrmAdmin::with('attendances')->get();

        $currentYear = Carbon::now()->year;
        $invoices = Invoice::whereYear('created_at', $currentYear)->get();

        $totalInvoiceSell = 0 ;

            foreach ($invoices as $invoice){

                $allProducts = json_decode($invoice->products, true);

                foreach ($allProducts as $allProduct) {
                    $quantity = floatval($allProduct['quantity']);
                    $unitPrice = floatval($allProduct['unit_price']);

                    $totalSale = $quantity * $unitPrice;
                    $totalInvoiceSell  += $totalSale;
                }

            }


//      ======== Query Transfer Request ======
        $assignRequests = AssignReq::with('users', 'queries', 'reqIds')->get()->all();

//      ======== Task ===========
        $totalTasks = AssignTask::with('users.profiles')
            ->where('status','!=','approve')
            ->orderByDesc('start_date')
            ->get();

        $statuses = QueryStatus::all();


        if (\request()->ajax()) {
            return view('partials.queryTable', ['queries' => $queries,'statuses'=>$statuses])->render();
        }


//     ============ Users Sales Inquiry ==========

        if (!empty($salesDateForm) && !empty($salesDateTo)) {
            $usersData = User::with([
                'invoices' => function ($query) use ($salesDateForm, $salesDateTo) {
                    $query->whereBetween('created_at', [$salesDateForm, $salesDateTo]);
                },
                'queries' => function ($query) use ($salesDateForm, $salesDateTo) {
                    $query->whereBetween('created_at', [$salesDateForm, $salesDateTo]);
                },
                'quotations' => function ($query) use ($salesDateForm,$salesDateTo) {
                    $query->whereBetween('created_at', [$salesDateForm,$salesDateTo]);
                }
            ])->withCount('queries')
                ->get();
        } else {
            $currentMonth = now()->format('m');
            $currentYear = now()->format('Y');

            $usersData = User::with([
                'invoices' => function ($query) use ($currentMonth, $currentYear) {
                    $query->whereMonth('created_at', $currentMonth)
                        ->whereYear('created_at', $currentYear);
                },
                'queries' => function ($query) use ($currentMonth, $currentYear) {
                    $query->whereMonth('created_at', $currentMonth)
                        ->whereYear('created_at', $currentYear);
                },
                'quotations' => function ($query) use ($currentMonth, $currentYear) {
                    $query->whereMonth('created_at', $currentMonth)
                        ->whereYear('created_at', $currentYear);
                }
            ])->withCount('queries')
                ->get();
        }


//        ======== Expanse ========

            if (!empty($expenseDateForm) && !empty($expenseDateTo)){
                $expenses = Expanse::with('expenseNames')->
                whereBetween('created_at',[$expenseDateForm,$expenseDateTo])->paginate(7)->withQueryString();

            }else{
                $expenses = Expanse::with('expenseNames')->
                orderByDesc('created_at')->paginate(7)->withQueryString();
            }


//        dd($users);

        return view('admin.dashboard', compact(
            'users','queries','admins',
            'processingQuery','assignQuery','pendingQuery','quotationSent','closedQuery',
            'pendingQuery',
            'payments'
            ,'assignRequests','totalTasks','usersData'
            ,'expenses',
            'totalInvoiceSell',
            'statusCounts',
            'pageTitle'
        ));


    }

    public function queries()
    {
        $queries = $this->dashboard()->queries;

        if (request()->ajax()) {
            return View::make('partials.queryTable', compact('queries'))->render();
        }

        return response()->json($queries);

//        dd($queries);

    }


    public function assignTask(){

            $this->validate(\request(),[
                'user_id' => 'required',
                'title' => 'required',
                'description' => 'nullable|max:1000',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date'
            ]);

        try {
            AssignTask::create([
                'user_id' => \request('user_id'),
                'title' => \request('title'),
                'description' => \request('description'),
                'start_date' => \request('start_date'),
                'end_date' => \request('end_date'),
            ]);

            return redirect()->back()->with('success', 'Task Created Successfully');
        } catch (QueryException $e) {
            // If a database query exception occurs, handle it here.
            // You can log the error, display a user-friendly message, or perform any other necessary actions.
            return redirect()->back()->with('error', 'An error occurred while creating the task. Please try again later.');
        } catch (\Exception $e) {
            // If any other exception occurs, handle it here.
            // This catch block will catch exceptions other than database query exceptions.
            // You can log the error, display a user-friendly message, or perform any other necessary actions.
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }


    }

    public function queryRequest($query_id){

        $userId = \request('user');
        $requestId = Auth::user()->id;

        $this->validate(\request(),[
            'user' => 'required',
        ]);

        AssignReq::create([
                'user_id' => $userId,
                'query_id' => $query_id,
                'request_id' => $requestId,
        ]);

        return redirect()->back()->with('success','Transfer Request Has Sent To Admin');
    }

    public function assignQuery($query_id){

        $this->validate(\request(),[
            'user' => 'required',
        ]);
        $user = \request('user');

        if ($user == 0) {
            return redirect()->back()->with('error', 'Please select an user');
        }

        $query = Query::find($query_id);
        if ($query) {
            $query->update(['user_id' => $user]);
        }

        return redirect()->back()->with('success','Query Transfer Successfully');
    }


    public function approveTask($id){

        AssignTask::where('id',$id)->update([
            'status' => 'approve',
        ]);

        return redirect()->back();
    }

    public function jobFailed($id){

        AssignTask::where('id',$id)->update([
            'status' => 'failed'
        ]);

        return redirect()->back();

    }



}
