<?php

namespace Domain\Contact\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected $name;

    /**
     * Create a new message instance.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@wedevelop4you.nl', 'WeDevelop4You')
            ->subject('contact')
            ->markdown('mail.contact')
            ->with([
                'customer' => $this->name,
            ]);
    }
}
