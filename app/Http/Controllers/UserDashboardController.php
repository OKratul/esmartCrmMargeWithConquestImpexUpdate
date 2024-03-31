<?php

namespace App\Http\Controllers;

use App\Models\AssignReq;
use App\Models\AssignTask;
use App\Models\CustomerModel;
use App\Models\DeliveryTerm;
use App\Models\Expanse;
use App\Models\Invoice;
use App\Models\MailAccount;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Query;
use App\Models\QuerySource;
use App\Models\QueryStatus;
use App\Models\Quotation;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warranty;
use App\Notifications\QueryNotification;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Webklex\IMAP\Facades\Client;
use function Symfony\Component\String\s;

class UserDashboardController extends Controller
{
    public function index (){

        $pageTitle = 'User Dashboard';

        $queryDateForm = \request('query_date_form');
        $queryDateTo = \request('query_date_to');
        $queryStatus = \request('status');

        $paymentDateTo = \request('payment_date_to');
        $paymentDateForm = \request('payment_date_form');

        $payments = Payment::all()->pluck('amount');
        $totalPayment = $payments->sum();

        $invoiceProducts = Invoice::where('user_id',Auth::user()->id)->get()->all();

        $quotations = Quotation::where('user_id',Auth::user()->id)->get()->all();

        $totalQuotationPrice = 0;


        //      ===== Query Search code ======
        if (!empty($queryDateForm) && !empty($queryDateTo)){
            $queries = Query::with('users','customers','notes')
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->orderByDesc('created_at')
                ->paginate(7)->withQueryString();

            $pendingQuery = Query::with('customers')
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->where('user_id',null)->get();
            $processingQuery = Query::with('users','customers')
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->where('status','Processing')->get();
            $assignQuery = Query::with('users','customers')
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->where('user_id',Auth::user()->id)
                ->get();
            $quotationSent = Query::with('users','customers')
                ->whereBetween('created_at',[$queryDateForm,$queryDateTo])
                ->where('status','Quotation Sent')->get();
            $closedQuery = Query::whereBetween('created_at',[$queryDateForm,$queryDateTo])->where('status','Closed')->get();

        }elseif(!empty($queryStatus)){
            $queries = Query::with('users','customers','notes')
                ->where('status', $queryStatus)
                ->orderByDesc('created_at')
                ->paginate(7)
                ->withQueryString();

            $pendingQuery = Query::where('user_id',null)->get();
            $processingQuery = Query::where('status','Processing')->get();
            $assignQuery = Query::where('user_id',Auth::user()->id)
                            ->orWhere('status',$queryStatus)
                            ->get();
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

            $pendingQuery = Query::where('user_id',null)->get();
            $processingQuery = Query::where('status','Processing')->get();
            $assignQuery = Query::where('user_id',Auth::user()->id)->get();
            $quotationSent = Query::where('status','Quotation Sent')->get();
            $closedQuery = Query::where('status','Closed')->get();

        }
//        ==== Pending Queries ======

        $pendingQueries = Query::where('user_id',null)
                        ->with('customers')
                        ->paginate(7)->withQueryString();

//        ===== Payments Code

        if (!empty($paymentDateForm) && !empty($paymentDateTo)){

            $payments = Payment::whereBetween('created_at',[$paymentDateForm,$paymentDateTo])
                ->with('customers','invoices')->paginate(7)->withQueryString();

        }else{
            $payments = Payment::paginate(7)->withQueryString();
        }


        foreach ($quotations as $quotation){
            $allProducts = json_decode($quotation->products, true);

            foreach ($allProducts as $product){
                $quantity = $product['quantity'];
                $unitPrice = $product['unit_price'];

                // Convert string values to floats
                $quantity = floatval($quantity);
                $unitPrice = floatval($unitPrice);

                $quotationPrice = $quantity * $unitPrice;
                $totalQuotationPrice += $quotationPrice;
            }

        }

        $expenses = Expanse::with('expenseNames')
                            ->orderByDesc('created_at')
                            ->paginate(5)
                            ->withQueryString();

        $totalQuotation = count($quotations);

//        foreach ()

//        total Invoice Sells

        $invoices = Invoice::where('user_id',Auth::user()->id)
                            ->with('users','customers','payments','expanses')
                            ->get();


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

        $totalDue = $totalInvoiceSell - $totalPayment;
//        dd($totalQuotationPrice);
//        $products = json_decode($invoiceProducts['products'], true);



        $queryReminders = Query::where('user_id', Auth::user()->id)
            ->orWhere('reminder_date', now()->format('Y-m-d'))
            ->orderBy('status')
            ->with('users','customers')
            ->paginate(7)->withQueryString();

        $queryCount = Query::where('user_id',Auth::user()->id)->get()->count();

        $tasks = AssignTask::where('user_id', Auth::user()->id)
            ->where('status', '!=', 'approve')
            ->orderByDesc('start_date')
            ->paginate(5)
            ->withQueryString();

        $allTasks = AssignTask::where('user_id',Auth::user()->id)
            ->orderBy('status')
            ->orderBy('start_date')
            ->get()->all();

//        dd($pendingQueries);

        $requestQueries = AssignReq::where('request_id',Auth::user()->id)->with('reqIds','queries')->get()->all();

        $user= Auth::user();

//        $noti = $user->notifications;

//        dd($noti);


        $pendingQuery = Query::where('user_id',null)->count();
        $processingQuery = Query::where('status','Processing')->count();
//        $processingQuery = Query::where('status','Processing')->count();
        $quotationSent = Query::where('status','Quotation Sent')->count();
        $orderConfirmed = Query::where('status','Order Confirmed')->count();
        $deliveryOnGoing = Query::where('status','Delivery On Going')->count();
        $delivered = Query::where('status','Delivered')->count();
        $closed = Query::where('status','Closed')->count();

        $users = User::all();
        $counts = [$processingQuery, $quotationSent, $orderConfirmed, $deliveryOnGoing,$delivered,$closed];

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


        $queryStatus = QueryStatus::get('query_status');

        $statusCounts = $queryStatus->map(function ($status, $index) use ($counts) {
            return [
                'statusName' => $status->query_status,
                'count' => $counts[$index], // Use $index to get the corresponding count for each status
            ];
        })->toArray();



        $totalDue= floor($totalDue);
        $totalInvoiceSell = floor($totalInvoiceSell);
        $totalQuotationPrice = floor($totalQuotationPrice);

        $user = Auth::user();
        $notifications = $user->unreadNotifications;

//        dd($notifications);

        $users =User::all();
        $customers = CustomerModel::all();

        $unites = Unit::all();
        $statuses = QueryStatus::all();
        $querySources = QuerySource::all();
        $deliveryTerms = DeliveryTerm::all();
        $paymentTypes = PaymentType::all();
        $warranties = Warranty::all();

        $queryStatus = QueryStatus::all();

        return view('user.userDashboard',

            compact('totalPayment','totalDue',
                             'quotations','totalQuotation','totalQuotationPrice',
                             'queryStatus',
                             'queries',
                             'pendingQuery',
                            'processingQuery',
                            'queryReminders',
                             'assignQuery',
                            'quotationSent',
                            'totalInvoiceSell',
                            'closedQuery',
                            'payments',
                            'tasks','allTasks','requestQueries',
                                'notifications','users','unites','statuses','querySources','deliveryTerms'
                                ,'paymentTypes','warranties',
                            'pendingQueries',
                            'expenses',
                            'customers',
                            'statusCounts',
                            'pageTitle'
                             ));

    }

//    =======Task Undone =====

    public function taskUndo($task_id){

        AssignTask::where('id',$task_id)->update([
            'status' => 'pending'
        ]);

        return redirect()->back();

    }

    public function queryReqUpdate($req_id,$query_id){

        Query::where('id',$query_id)->update([
            'user_id' => Auth::user()->id,
        ]);

        AssignReq::where('id',$req_id)->delete();

        return redirect()->back();

    }

    public function queryReqDecline($req_id){

        AssignReq::where('id',$req_id)->delete();

        return redirect()->back();

    }

//================



    public function querySelfAssign($query_id){
        Query::where('id',$query_id)->update([
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success','Query Assigned To Your Profile ');
    }

    public function checkAssign($id){
            AssignTask::where('id',$id)->update([
                'status' => 'done',
            ]);

            return redirect()->back();
    }




}
