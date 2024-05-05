<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuotationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $customers;
    public $quotation;
    public $pdfSetup;
    public function __construct($customer_id,$quotation)
    {
        $this->customers = $customer_id;
        $this->quotation = $quotation;
        $this->pdfSetup = $pdfSetup;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Quotation Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
//            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    public function build(){
        return $this->view('emailTemplate.quotationMail')
            ->subject('Quotation Mail')
            ->attachData($this->generatePdf(), 'quotation.pdf', [
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

        $pdf->WriteHTML(view('pdf.quotationPdf', ['quotation' => $this->quotation,'pdfSetup'=>$this->pdfSetup])->render());

        // Output the PDF as a string
        return $pdf->Output('', 'S');
    }
}
