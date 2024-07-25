<?php

namespace App\Http\Controllers;

use App\Models\LoanDetail;
use Illuminate\Http\Request;

class LoanDetailController extends Controller
{
    public function index()
    {
        return view('loan_details.index');
    }

    public function fetchLoanData()
    {
        // $loanDetails = LoanDetail::all();
        // return response()->json($loanDetails);

        $employees = LoanDetail::all();
        return response()->json([
            'employees'=>$employees,
        ]);
    }
}