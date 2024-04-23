<?php

namespace App\Http\Controllers;

use App\Models\AdminProfileModel;
use App\Models\CrmAdmin;
use App\Models\DeliveryTerm;
use App\Models\ExpenseName;
use App\Models\PaymentType;
use App\Models\PDFsetup;
use App\Models\Query;
use App\Models\QuerySource;
use App\Models\QueryStatus;
use App\Models\Unit;
use App\Models\User;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index(){

        $profileInfos = AdminProfileModel::where('admin_id', Auth::guard('admin')->id())->first();

        return view('admin.adminSettings',compact('profileInfos'));

    }

    public function adminProfile(){

        $data = $this->validate(request(), [
            'pro_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:800',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $adminId = Auth::guard('admin')->id();
        $proImgUrl = null; // Initialize to null

        if (!empty($data['pro_img'])) {
            $proImgExt = request()->file('pro_img')->extension();
            $proImgName = 'Admin' . '_' . 'pro_img' . rand(111, 999) . '_' . $data['name'] . '.' . $proImgExt;
            request()->file('pro_img')->move('images/profiles', $proImgName);
            $proImgUrl = asset('images/profiles/' . $proImgName);
        }

        $profileInfo = AdminProfileModel::where('admin_id', $adminId)->first();

        if ($profileInfo){
            $profileInfo->update([
                'name' => $data['name'],
                'pro_img' => $proImgUrl, // Update only when an image is uploaded
            ]);
        } else {
            AdminProfileModel::create([
                'admin_id' => $adminId,
                'name' => $data['name'],
                'pro_img' => $proImgUrl, // Set to null if no image is uploaded
            ]);
        }

        CrmAdmin::where('id', $adminId)->update([
            'username' => $data['name'],
            'email' => $data['email'],
        ]);

        return redirect()->back()->with('success', 'Profile updated');
    }




    public function optionsView(){

        $users = User::all();
        $pdfSets = PDFsetup::orderByDesc('created_at')->get();

        return view('adminOptions', compact('users','pdfSets'));

    }

    public function unitAdd(){

        $this->validate(\request(),[
            'unit' => 'required',
        ]);

        Unit::create([
            'unit'=> \request('unit')
        ]);

        return redirect()->back()->with('success','Unit Added Successfully'.' '.\request('unit'));

    }

    public function editUnit($id){
        $this->validate(\request(),[
            'unit' => 'required',
        ]);

        Unit::where('id',$id)->update([
            'unit' => \request('unit')
        ]);

        return redirect()->back()->with('success','Unit Updated' .' '.\request('unit'));
    }

    public function deleteUnit($id){

        Unit::where('id',$id)->delete();

        return redirect()->back()->with('success','Unit deleted');

    }

    public function querySourceAdd(){

        $this->validate(\request(),[
            'query_source' => 'required',
        ]);

        QuerySource::create([
            'query_source' => \request('query_source')
        ]);

        return redirect()->back()->with('success','Query Source Added');

    }

    public function editQuerySource($id){

        $this->validate(\request(),[
            'query_source' => 'required'
        ]);

        QuerySource::where('id',$id)->update([
            'query_source' => \request('query_source'),
        ]);

        return redirect()->back()->with('success', 'Query Source Updated'.' ' .\request('query_source'));

    }


    public function deleteQuerySource($id){

        QuerySource::where('id',$id)->delete();

        return redirect()->back()->with('success', 'Query Source Deleted');

    }

    public function queryStatusAdd(){

        $this->validate(\request(),[
            'query_status' => 'required',
        ]);

        QueryStatus::create([
            'query_status' => \request('query_status')
        ]);

        return redirect()->back()->with('success','Query Status Added'. ' ' .\request('query_status'));

    }

    public function editQueryStatus($id){
        $this->validate(\request(),[
            'query_status' => 'required',
        ]);

        QueryStatus::where('id',$id)->update([
            'query_status' => \request('query_status')
        ]);

        return redirect()->back()->with('success','Query Status Edited'. ' ' .\request('query_status'));

    }

    public function deleteQueryStatus($id){

        QueryStatus::where('id',$id)->delete();
        return redirect()->back()->with('success', 'Query Status Deleted');

    }



    public function deliveryTermAdd(){

        $this->validate(\request(),[
            'delivery_term' => 'required',
        ]);

        DeliveryTerm::create([
            'delivery_term'=> \request('delivery_term')
        ]);

        return redirect()->back()->with('success','Delivery Term Added'.' '.\request('delivery_term'));

    }

    public function editDeliveryTerm($id){

        $this->validate(\request(),[
            'delivery_term' => 'required',
        ]);

        DeliveryTerm::where('id',$id)->update([
            'delivery_term' => \request('delivery_term')
        ]);

        return redirect()->back()->with('success','Delivery Term Updated'.' '.\request('delivery_term'));

    }

    public function deleteDeliveryTerms($id){

        DeliveryTerm::where('id',$id)->delete();
        return redirect()->back()->with('success','Delivery Term Deleted');

    }

    public function paymentTypeAdd(){

        $this->validate(\request(),[
            'payment_type' => 'required',
        ]);

        PaymentType::create([
            'payment_type' => \request('payment_type')
        ]);

        return redirect()->back()->with('success','Payment Type Added Successfully'.' '. \request('payment_type') );

    }

    public function editPaymentType($id){

        $this->validate(\request(),[
            'payment_type' => 'required',
        ]);

        PaymentType::where('id',$id)->update([
            'payment_type' => \request('payment_type')
        ]);

        return redirect()->back()->with('success','Payment Type Updated'.' '.\request('payment_type'));

    }

    public function deletePaymentType($id){

        PaymentType::where('id',$id)->delete();

        return redirect()->back()->with('success','Payment Type Deleted');

    }

    public function warrantyAdd(){

        $this->validate(\request(),[
            'warranty' => 'required',
        ]);

        Warranty::create([
            'warranty' => \request('warranty')
        ]);

        return redirect()->back()->with('success','Warranty Added');

    }

    public function editWarranty($id){

        $this->validate(\request(),[
            'warranty' => 'required',
        ]);

        Warranty::where('id',$id)->update([
            'warranty' => \request('warranty')
        ]);

        return redirect()->back()->with('success','Warranty option Updated'.' '.\request('warranty'));

    }

    public function deleteWarranty($id){

        Warranty::where('id',$id)->delete();
        return redirect()->back()->with('success','Warranty option Deleted');

    }

    public function addExpense(){

        $this->validate(\request(),[
            'expense' => 'required',
        ]);

        ExpenseName::create([
            'expense_name' => \request('expense')
        ]);

        return redirect()->back()->with('success','Expense Name Added');

    }

}
