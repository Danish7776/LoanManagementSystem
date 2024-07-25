<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ProcessDataController extends Controller
{
    public function showPage()
    {
        $emiDetails = [];
        if (Schema::hasTable('emi_details')) {
            $emiDetails = DB::table('emi_details')->get();
        }

        return view('loan_details.process_data', compact('emiDetails'));
    }

    public function showProceessPage()
    {
        return view('loan_details.process_data');
    }

    public function processData(Request $request)
    {
        try{
            $dates = DB::table('loan_details')
                        ->selectRaw('MIN(first_payment_date) as min_date, MAX(last_payment_date) as max_date')
                        ->first();

            $minDate = Carbon::parse($dates->min_date);
            $maxDate = Carbon::parse($dates->max_date);

            $columns = [];
            while ($minDate->lte($maxDate)) {
                $columns[] = $minDate->format('Y_M');
                $minDate->addMonth();
            }

            DB::statement('DROP TABLE IF EXISTS emi_details');

            $createTableQuery = 'CREATE TABLE emi_details (
                clientid INT NOT NULL';

            foreach ($columns as $column) {
                $createTableQuery .= ", $column DECIMAL(15, 2) DEFAULT 0";
            }

            $createTableQuery .= ', PRIMARY KEY (clientid))';

            DB::statement($createTableQuery);

            $loanDetails = DB::table('loan_details')->get();

            foreach ($loanDetails as $loan) {
                $emi = round($loan->loan_amount / $loan->num_of_payment, 2);
                $clientPayments = [];
                $currentDate = Carbon::parse($loan->first_payment_date);

                for ($i = 0; $i < $loan->num_of_payment; $i++) {
                    $monthColumn = $currentDate->format('Y_M');
                    if (!isset($clientPayments[$monthColumn])) {
                        $clientPayments[$monthColumn] = 0;
                    }
                    $clientPayments[$monthColumn] += $emi;
                    $currentDate->addMonth();
                }

                $totalPaid = array_sum($clientPayments);
                if ($totalPaid != $loan->loan_amount) {
                    $lastMonthColumn = $currentDate->subMonth()->format('Y_M');
                    $clientPayments[$lastMonthColumn] += ($loan->loan_amount - $totalPaid);
                }

                $insertQuery = 'INSERT INTO emi_details (clientid, ' . implode(',', array_keys($clientPayments)) . ')
                                VALUES (' . $loan->clientid . ', ' . implode(',', $clientPayments) . ')';
                DB::statement($insertQuery);
            }

            return redirect()->route('process.data.show')->with('success', 'EMI details table created and data processed successfully.');
        
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}