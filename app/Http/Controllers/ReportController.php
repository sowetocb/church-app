<?php

namespace App\Http\Controllers;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function allDonationsReport()
{
    // Use ->paginate(10) to support your custom pagination snippet
    $donations = Donation::with('cause')->orderBy('created_at', 'desc')->paginate(10);

    // Because we’re now paginating, we can’t just do $donations->sum('amount') on the entire set
    // If you want the total of all pages, do a separate query:
    $totalAmount = Donation::sum('amount');

    return view('reports.all_donations', compact('donations', 'totalAmount'));
}


public function donationsPerCause()
{
    // Now we use paginate() instead of get()
    $donations = Donation::with('cause')
        ->select(
            'cause_id',
            DB::raw('COUNT(*) as total_donations'),
            DB::raw('SUM(amount) as total_amount')
        )
        ->groupBy('cause_id')
        ->paginate(10);  // e.g., 10 items per page

    $grandTotal = $donations->sum('total_amount');

    return view('reports.donations_per_cause', compact('donations', 'grandTotal'));
}



public function paidPendingByCause()
{
    // Paginate to use your custom table pagination snippet
    $stats = Donation::select(
            'cause_id',
            'payment_status',
            DB::raw('COUNT(*) as donation_count'),
            DB::raw('SUM(amount) as amount_sum')
        )
        ->groupBy('cause_id', 'payment_status')
        ->with('cause')
        ->paginate(10); // e.g. 10 items per page

    return view('reports.paid_pending_by_cause', compact('stats'));
}


public function paidPendingReport()
{
    // Summary data
    $paidCount = Donation::where('payment_status', 'paid')->count();
    $paidTotal = Donation::where('payment_status', 'paid')->sum('amount');

    $pendingCount = Donation::where('payment_status', 'pending')->count();
    $pendingTotal = Donation::where('payment_status', 'pending')->sum('amount');

    // Overall totals
    $overallTotal = Donation::sum('amount');
    $overallCount = Donation::count();

    // If you want to display both paid + pending in one table, do:
    $donations = Donation::whereIn('payment_status', ['paid', 'pending'])
        ->latest()
        ->paginate(10);

    return view('reports.paid_pending', compact(
        'paidCount', 'paidTotal',
        'pendingCount', 'pendingTotal',
        'overallTotal', 'overallCount',
        'donations'
    ));
}


public function allInOneReport()
{
    // 1) All Donations
    $allDonations = Donation::with('cause')->get();
    $allDonationsTotal = $allDonations->sum('amount');

    // 2) Per Cause
    $donationsPerCause = Donation::with('cause')
        ->select('cause_id',
            DB::raw('COUNT(*) as total_donations'),
            DB::raw('SUM(amount) as total_amount')
        )
        ->groupBy('cause_id')
        ->get();
    $grandTotalAllCauses = $donationsPerCause->sum('total_amount');

    // 3) Paid vs Pending
    $paidCount = Donation::where('payment_status', 'paid')->count();
    $paidTotal = Donation::where('payment_status', 'paid')->sum('amount');
    $pendingCount = Donation::where('payment_status', 'pending')->count();
    $pendingTotal = Donation::where('payment_status', 'pending')->sum('amount');

    return view('reports.all_in_one', compact(
        'allDonations', 'allDonationsTotal',
        'donationsPerCause', 'grandTotalAllCauses',
        'paidCount', 'paidTotal', 'pendingCount', 'pendingTotal'
    ));
}

public function downloadAllDonationsPdf()
{
    // Get all donations for the report
    $donations = Donation::with('cause')->orderBy('created_at', 'desc')->get();

    // Compute totals
    $totalAmount  = $donations->sum('amount');
    $paidTotal    = $donations->where('payment_status', 'paid')->sum('amount');
    $pendingTotal = $donations->where('payment_status', 'pending')->sum('amount');

    return Pdf::loadView('reports.all_donations_pdf', compact('donations', 'totalAmount', 'paidTotal', 'pendingTotal'))
              ->download('donations-report.pdf');
}

}
