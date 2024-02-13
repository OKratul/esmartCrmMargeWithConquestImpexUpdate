<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     *
     * @param mixed $invoice
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emailTemplate.invoiceMail')
            ->subject('Invoice Mail')
            ->attachData($this->generatePdf(), 'invoice.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Generate the PDF content.
     *
     * @return string
     */
    protected function generatePdf()
    {
        $pdf = new \Mpdf\Mpdf([
            'format' => 'A4',
        ]);

        $pdf->WriteHTML(view('pdf.invoicePdf', ['invoice' => $this->invoice])->render());

        // Output the PDF as a string
        return $pdf->Output('', 'S');
    }
}
