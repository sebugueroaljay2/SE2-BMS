<?php

namespace App\Http\Controllers;

use App\Models\BarangayRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequestListController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/RequestLists/RequestList', [
            'request_list' =>  BarangayRequest::orderByDesc('id')->with('status')->with('payment_type')->get(),
            'status' => Status::all(),
        ]);
    }

    public function processing_request()
    {
        return Inertia::render('Admin/RequestLists/ProcessingRequest', [
            'request_list' =>  BarangayRequest::orderByDesc('id')->with('status')->with('payment_type')->get(),
            'status' => Status::all(),
        ]);
    }

    public function ready_to_pick_up_request()
    {
        return Inertia::render('Admin/RequestLists/ReadyToPickUp', [
            'request_list' =>  BarangayRequest::orderByDesc('id')->with('status')->with('payment_type')->get(),
            'status' => Status::all(),
        ]);
    }

    public function released_request()
    {
        return Inertia::render('Admin/RequestLists/ReleasedRequest', [
            'request_list' =>  BarangayRequest::orderByDesc('id')->with('status')->with('payment_type')->get(),
            'status' => Status::all(),
        ]);
    }

    

    // public function destroy($id)
    // {
    //     $transaction = BarangayRequest::find($id);

    //     if (!$transaction) {
    //         return response()->json(['message' => 'Transaction not found'], 404);
    //     }

    //     $transaction->delete();

    //     return response()->json(['message' => 'Transaction deleted successfully']);
    // }

    
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'status_id' => 'required|exists:statuses,id',
    //     ]);

    //     $transaction = BarangayRequest::findOrFail($id);
    //     $transaction->status_id = $request->status_id;
    //     $transaction->save();

    //     return response()->json([
    //         'message' => 'Transaction updated successfully!',
    //         'data' => $transaction
    //     ]);
    // }

    

}

// public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'status_id' => 'required|integer',
    //     ]);

    //     $transaction = BarangayRequest::findOrFail($id);
    //     $transaction->update(['status_id' => $request->status_id]);

    //     return response()->json([
    //         'message' => 'Transaction status updated successfully!',
    //         'transaction' => $transaction,
    //     ]);
    // }

    // public function update(Request $request, BarangayRequest $transaction)
    // {
    //     $validated = $request->validate([
    //         'status_id' => ['required'],
    //     ]);

    //     $transaction->update($validated);

    //     return response()->json($transaction);
    // }