<?php

namespace App\Http\Controllers;

use App\Models\BarangayRequest;
use App\Models\PaymentType;
use App\Models\Request as ModelsRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;


class ResidencyCertificatesController extends Controller
{
    public function index(){
        return Inertia::render('Resident/Services/ResidencyCertificates',[
            'payment_method' => PaymentType::all(),
            'services' => Service::find(3),   
            
        ]);
    }

  public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'first_name' => ['required', 'regex:/^[A-Za-z\s]+$/'],
        'last_name' => ['required', 'regex:/^[A-Za-z\s]+$/'],
        'pick_up_date' => 'required|date',
        'purposes' => 'required|string',
        'payment_type_id' => 'required|integer',
        'request_type_id' => 'required|integer',
        'reference_no' => 'required|numeric|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $validated = $validator->validated();

    // 🔹 Generate unique tracking code
    $last = BarangayRequest::latest('id')->first();
    $nextId = $last ? $last->id + 1 : 1;
    $validated['tracking_code'] = 'BRGY-' . date('Ymd') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

    // 🔹 Save to database
    $transaction = BarangayRequest::create($validated);

    return response()->json($transaction, 201);
}



}
