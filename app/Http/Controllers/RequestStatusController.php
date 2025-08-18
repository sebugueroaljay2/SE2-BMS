<?php

namespace App\Http\Controllers;

use App\Models\BarangayRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequestStatusController extends Controller
{
    public function index(){
        return Inertia::render('Resident/Status/RequestStatus',[
            'status' => BarangayRequest::orderByDesc('id')->with('status')->get(),
        ]);
    }
}
