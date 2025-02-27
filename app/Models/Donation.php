<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'donor_name',
        'donor_email',
        'mobile_number',
        'amount',
        'message',
        'cause_id',
        'donation_image',
        'payment_status',
        'transaction_id',
    ];

    // Optional: if you want to easily know if this is event-specific:
        public function user()
        {
            return $this->belongsTo(User::class);
        }

    public function cause()
    {
        // The second argument is the foreign key in donations
        // referencing the primary key of the causes table
        return $this->belongsTo(Cause::class, 'cause_id');
    }
}
