<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Cause as DonationEvent; // Alias to avoid conflicts
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Cause;
use Illuminate\Database\Eloquent\Model;


class DonationController extends Controller
{
    // ***********************
    // GENERAL DONATIONS
    // ***********************

    // Show form for a general donation (via mobile number)
    public function General()
    {
        return view('donations.general.create');
    }

    // Store a general donation
    public function storeGeneral(Request $request)
    {
        $request->validate([
            'donor_name'    => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'amount'        => 'required|numeric|min:1',
            'message'       => 'nullable|string',
            'donation_image'=> 'nullable|image|max:2048',
        ]);

        $data = $request->only(['donor_name', 'mobile_number', 'amount', 'message']);
        $data['payment_status'] = 'pending';

        // Handle file upload if provided
        if ($request->hasFile('donation_image')) {
            $data['donation_image'] = $request->file('donation_image')->store('donation_images', 'public');
        }

        Donation::create($data);

        return redirect()->route('donations.general.create')
                         ->with('success', 'Thank you for your donation!');
    }

    // ***********************
    // EVENT-SPECIFIC DONATIONS
    // ***********************

    // Show the donation form for a specific event
    public function createEventDonation(DonationEvent $causes)
    {
        return view('donations.create', compact('causes'));
    }

    // Store an event-specific donation promise (with pending/paid state)
    public function storeEventDonation(Request $request, DonationEvent $causes)
    {
        $request->validate([
            'donor_name'    => 'required|string|max:255',
            'donor_email'   => 'required|email|max:255',
            'amount'        => 'required|numeric|min:1',
            'message'       => 'nullable|string',
            'donation_image'=> 'nullable|image|max:2048',
        ]);

        $data = $request->only(['donor_name', 'donor_email', 'amount', 'message']);
        $data['event_id'] = $causes->id;
        $data['payment_status'] = 'pending';

        if ($request->hasFile('donation_image')) {
            $data['donation_image'] = $request->file('donation_image')->store('donation_images', 'public');
        }

        Donation::create($data);

        return redirect()->route('donations.table', $causes->id)
                         ->with('success', 'Your donation promise has been recorded!');
    }

    // Display event-specific donations as cards (paginated, 3 per page)
    public function eventDonationCards(DonationEvent $causes)
    {
        $donations = Donation::where('event_id', $causes->id)
            ->latest()
            ->paginate(3);

        return view('donations.cards', compact('event', 'donations'));
    }

    
    // ***********************
    // STATIC VIEW FOR MOBILE PAYMENT INFO
    // ***********************

    public function mobilePaymentInfo()
    {
        return view('donations.general.mobile_info');
    }

    /**
 * Display "My Own Donation Event" cards.
 */
public function myOwnDonationEvents()
{
    // If you only want to show donations that are NOT linked to an event, you can filter:
    // ->whereNull('event_id')
    // Otherwise, just show all donations or use any logic you need
    $causes = Cause::latest()->paginate(1);
    $donations = Donation::latest()->paginate(3);

    return view('donations.my_own_donations', compact('donations','causes'));
}

// 1. Show the "New Church Donation" card page
public function showMyOwnCause()
{
    // If you want to display some recent donations for transparency,
    // or remove this if you don't want to show any existing donations:

        $causes = Cause::latest()->paginate(1);
    $donations = Donation::whereNull('event_id')
        ->latest()
        ->take(6) // show up to 6
        ->get();

    // Return the Blade view with the cause card + optional donations
    return view('donations.my_own_donations', compact('donations','causes'));
}

// 2. Show the donation form for this custom cause
public function createMyOwnDonation()
{
    return view('donations.my_own_create'); 
}

// 3. Store the custom cause donation
public function storeMyOwnDonation(Request $request)
{
    $request->validate([
        'donor_name'    => 'required|string|max:255',
        'amount'        => 'required|numeric|min:1',
        'donation_image'=> 'nullable|image|max:2048',
        'message'       => 'nullable|string',
    ]);

    $data = $request->only(['donor_name', 'amount', 'message']);
    $data['payment_status'] = 'pending';

    // Handle file upload if provided
    if ($request->hasFile('donation_image')) {
        $data['donation_image'] = $request->file('donation_image')->store('donation_images', 'public');
    }

    // Save the donation to the DB (event_id remains null)
    Donation::create($data);

    return redirect()
        ->route('donations.myOwnCause')
        ->with('success', 'Thank you for donating to the new church cause!');
}

public function myOwnDonationTable()
{
    // For a "my own cause" donation, we assume event_id is null
    // (or you can use a custom field if you prefer)
    $causes = Cause::latest()->paginate(1);
    $donations = \App\Models\Donation::whereNull('event_id')
        ->latest()
        ->paginate(10);

    return view('donations.my_own_donations_table', compact('donations','causes'));
}

 // Show the donation form for a specific cause
 public function createCauseDonation(Cause $cause)
 {
     // $cause is resolved by route model binding: /cause/{cause}
     return view('donations.causes.create', compact('cause'));
 }

// Store a cause-specific donation
public function storeCauseDonation(Request $request, Cause $cause)
{
    $request->validate([
        'donor_name'     => 'required|string|max:255',
        'donor_contact'  => 'required|string|max:255',
        'amount'         => 'required|numeric|min:1',
        'message'        => 'nullable|string',
        'donation_image' => 'nullable|image|max:2048',
    ]);

    $data = [
        'donor_name'     => $request->donor_name,
        'donor_email'    => $request->donor_contact, // Storing contact as donor_email
        'amount'         => $request->amount,
        'message'        => $request->message,
        'payment_status' => 'pending',
        'user_id'        => auth()->id(), // Add user_id here
    ];

    // Ensure the correct foreign key column is used for the cause
    $data['cause_id'] = $cause->id;

    if ($request->hasFile('donation_image')) {
        $data['donation_image'] = $request->file('donation_image')->store('donation_images', 'public');
    }

    // Save the donation
    Donation::create($data);

    // Redirect to the "My Donations" report
    return redirect()
        ->route('reports.myDonations')
        ->with('success', 'Your donation promise has been recorded!');
}


public function myDonationsReport()
{
    // Retrieve one cause per page for the auto-advance section
    $causes = \App\Models\Cause::latest()->paginate(1);

    // Retrieve donations for the logged-in user
    $donations = \App\Models\Donation::where('user_id', auth()->id())->paginate(10);

    return view('reports.my_donations', compact('causes', 'donations'));
}


// Example: show a table of donations for this cause
public function eventDonationTable(Cause $cause)
{
    // We treat event_id as if it references the cause
    $donations = Donation::where('event_id', $cause->id)
        ->latest()
        ->paginate(10);

    // Return a Blade view that shows the table
    // e.g. resources/views/donations/table.blade.php
    // We'll pass $cause (for the cause info) and $donations
    return view('donations.table', compact('cause', 'donations'));
}

public function allDonationsTable()
{
    // Fetch all donations, regardless of cause
    $donations = Donation::latest()->paginate(10);
   
    // Return a view that lists them in a single table
    return view('donations.table_all_causes', compact('donations'));
}
 
public function causesAndDonations(Request $request)
{
    // 1. "Causes" - one per page for auto-advance
    
    $causes = Cause::paginate(1);
    
    if ($request->ajax()) {
        return view('donations.causes', compact('causes'));
    }
   
    
   
    // 2. "Recent Donations" - e.g. 10 per page
    // or if you only want them as a plain list, remove paginate
    $donations = Donation::latest()->paginate(10);

    return view('donations.causes_and_donations', compact('causes', 'donations'));
}

public function approveDonation(Request $request, Donation $donation)
{
    // Ensure user is authorized to approve
    // e.g., if(!auth()->user()->isAdmin()) { abort(403); }
    
    // Update the donation status to 'paid'
    $donation->payment_status = 'paid';
    $donation->save();

    return redirect()->back()->with('success', 'Donation approved (marked as paid).');
}



}
