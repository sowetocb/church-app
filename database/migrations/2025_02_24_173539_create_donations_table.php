<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
           
            $table->string('donor_name')->nullable();
            $table->string('donor_email')->nullable();
            $table->string('mobile_number')->nullable(); // for general donations
            $table->decimal('amount', 11, 2);
            $table->text('message')->nullable();
            $table->unsignedBigInteger('cause_id')->nullable();
            $table->foreign('cause_id')->references('id')->on('causes')->onDelete('set null');
            $table->string('donation_image')->nullable(); // file path for uploaded image
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            $table->string('transaction_id')->nullable(); // if needed
            $table->timestamps();
            
           
        });
    }

    public function down(): void
    {
        
Schema::table('donations', function (Blueprint $table) {
    $table->dropForeign(['user_id']);
    $table->dropColumn('user_id');
});
}
};