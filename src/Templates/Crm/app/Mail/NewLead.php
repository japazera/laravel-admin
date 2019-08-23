<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewLead extends Mailable
{
    use Queueable, SerializesModels;

	protected $lead;
	protected $my_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lead, $my_message = null)
    {
		$this->lead = $lead;
        $this->my_message = $my_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('crm@calina.ag', env('APP_NAME'))
			->subject(env('APP_NAME') . ' - Nova Mensagem do Lead: ' . $this->lead->email)
			->view('emails.leads.new')
			->with([
                'lead' => $this->lead,
                'message' => $this->my_message
            ]);;
    }
}
