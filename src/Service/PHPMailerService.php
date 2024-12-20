<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{
    private $pdfService;

    public function __construct(DomPDFService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function sendEmailWithAttachment(string $to, string $subject, string $body, string $from = 'your-email@example.com', string $htmlContentForPDF = ''): bool
    {
        $mailer = new PHPMailer(true);

        try {
           
            $mailer->isSMTP();
            $mailer->Host = '127.0.0.1';  
            $mailer->SMTPAuth = false;
            $mailer->Port = 1025;
            $mailer->SMTPSecure = false;

            
            $mailer->setFrom($from, 'Tu Nombre o Empresa');
            $mailer->addAddress($to);
            $mailer->Subject = $subject;
            $mailer->isHTML(true);
            $mailer->Body = $body;

            
            if ($htmlContentForPDF) {
                $pdfPath = $this->pdfService->generatePDF($htmlContentForPDF);
                $mailer->addAttachment($pdfPath); 
            }

            
            $mailer->send();

            return true;
        } catch (Exception $e) {
            
            error_log('Error al enviar correo: ' . $mailer->ErrorInfo);
            return false;
        }
    }
}
