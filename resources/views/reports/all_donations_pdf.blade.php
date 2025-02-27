<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Donations Report</title>
  <style>
    /* Basic styling for PDF */
    body { font-family: sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    table, th, td { border: 1px solid #333; }
    th, td { padding: 8px; text-align: left; }
    tfoot tr td { font-weight: bold; }
    .badge { padding: 4px 8px; border-radius: 4px; color: #fff; }
    .badge-success { background-color: green; }
    .badge-warning { background-color: orange; }
    .badge-danger { background-color: red; }
  </style>
</head>
<body>
  <h2>All Donations Report</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Cause</th>
        <th>Donor Name</th>
        <th>Email / Mobile</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      @foreach($donations as $donation)
      <tr>
        <td>{{ $donation->id }}</td>
        <td>{{ optional($donation->cause)->title ?? 'N/A' }}</td>
        <td>{{ $donation->donor_name }}</td>
        <td>{{ $donation->donor_email ?? $donation->mobile_number }}</td>
        <td>Tsh{{ number_format($donation->amount, 2) }}</td>
        <td>
          @if($donation->payment_status === 'paid')
            <span class="badge badge-success">Paid</span>
          @elseif($donation->payment_status === 'pending')
            <span class="badge badge-warning">Pending</span>
          @else
            <span class="badge badge-danger">{{ ucfirst($donation->payment_status) }}</span>
          @endif
        </td>
        <td>{{ $donation->created_at->format('M d, Y') }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="text-align: right;"><strong>Pending Total:</strong></td>
            <td colspan="3">Tsh{{ number_format($pendingTotal, 2) }}</td>
          </tr>
      <tr>
        <tr>
            <td colspan="4" style="text-align: right;"><strong>Paid Total:</strong></td>
            <td colspan="3">Tsh{{ number_format($paidTotal, 2) }}</td>

          </tr>

        <td colspan="4" style="text-align: right;"><strong>Total Amount:</strong></td>
        <td colspan="3">Tsh{{ number_format($totalAmount, 2) }}</td>
      </tr>
      
      
    </tfoot>
  </table>
</body>
</html>
