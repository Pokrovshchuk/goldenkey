<?php

namespace App\Mail;

use App\Models\Certificate;
use App\PDF\CertificatePDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CertificateCreated extends Mailable
{
    use Queueable, SerializesModels;

    public Certificate $certificate;
    public string $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
        $this->code = $certificate->str;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        $this->generatePDF();

        return $this->subject('Ваш сертификат в бизнес-зал')
            ->from('info@goldenkey.world')
            ->view('mail.send-code');
//            ->attach('pdf.certificate', ['as' => 'certificate']);
    }

    private function generatePDF()
    {
        $pdf = new CertificatePDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//        // set default monospaced font
//        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//
//        // set margins
//        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//
//        // set auto page breaks
//        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//
//        // set image scale factor
//        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//
//        // set default font subsetting mode
//        $pdf->setFontSubsetting(false);
//
//        // Set font
//        // dejavusans is a UTF-8 Unicode font, if you only need to
//        // print standard ASCII chars, you can use core fonts like
//        // helvetica or times to reduce file size.
//        $pdf->SetFont('dejavusans', '', 14, '', true);
//
//        // Add a page
//        // This method has several options, check the source code documentation for more information.
//        $pdf->AddPage();
//
//        // Set some content to print
//        $html = '<h1>Hello World !</h1>';
//
//        // Print text using writeHTMLCell()
//        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);


        Storage::disk('public')->put('certificates-pdf/' . $this->certificate->id . '.pdf', $pdf->Output('', 'S'));

        // TODO: remove testing
        $pdf->Output('', 'I');
    }
}
