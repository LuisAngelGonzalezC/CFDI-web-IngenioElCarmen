<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CfdiEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $cfdi;
    public $directory;
    public $tag;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cfdi, $tag)
    {
        $this->cfdi = $cfdi;
        $this->tag = $tag;
        $this->directory = storage_path('app/public/'.$this->tag->name.'/'.$cfdi->name);
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        
        return $this->markdown('emails.cfdi')
        ->subject('CFDI')
        ->attach($this->directory);
    }
}
