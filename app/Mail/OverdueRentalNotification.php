<?php
namespace App\Mail;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OverdueRentalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $rental;

    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    public function build()
    {
        return $this
            ->subject('Your Rental is Overdue')
            ->view('emails.overdue_rental')
            ->with(['rental' => $this->rental]);
    }
}

