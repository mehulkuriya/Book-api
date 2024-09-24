<?php
namespace App\Console\Commands;

use App\Models\Rental;
use Illuminate\Console\Command;
use App\Mail\OverdueRentalNotification;
use Mail;

class MarkOverdueRentals extends Command
{
    protected $signature = 'rentals:mark-overdue';
    protected $description = 'Mark rentals as overdue if not returned within 2 weeks';

    public function handle()
    {
    
        $overdueRentals = Rental::where('is_overdue', false)
            ->where('due_at', '<', now())->whereNull("returned_at")
            ->get();
        foreach ($overdueRentals as $rental) {
            $rental->is_overdue = true;
            $rental->save();
            Mail::to($rental->user->email)->send(new OverdueRentalNotification($rental));
        }
        $this->info('Overdue rentals marked successfully.');
    }
}
