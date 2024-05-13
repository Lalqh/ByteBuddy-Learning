<?php

require __DIR__ . '/../../vendor/autoload.php';

use ElasticEmail\Api\EmailsApi;
use ElasticEmail\Model\EmailMessageData;
use ElasticEmail\Model\EmailRecipient;
use ElasticEmail\Model\EmailContent;
use ElasticEmail\Model\BodyPart;
use ElasticEmail\Configuration;
use GuzzleHttp\Client;

class Email
{
    private $config;
    public function __construct()
    {
        $this->config = Configuration::getDefaultConfiguration()
            ->setApiKey(
                'X-ElasticEmail-ApiKey',
                'E4F36ECA4F5B0D5AE51DEC6B9BC1B7C934674EC87DAEF40886378AC66454F00D188498141BE78159BBC736B6DE6CD27'
            );
    }

    public function sendEmail($email, $subject, $password = "")
    {
        $htmlContent = '<!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <title>Nueva Contraseña{unsubscribe}</title>
                </head>
                <body>
                    <h1>Tu nueva contraseña es:</h1>
                    <p>' . $password . '</p>
                    <p>Este es un correo electrónico generado automáticamente. Por favor, no responder.</p>
                </body>
                </html>';

        $apiInstance = new EmailsApi(
            new Client(),
            $this->config
        );

        $email = new EmailMessageData(
            array(
                "recipients" => array(
                    new EmailRecipient(array("email" => $email))
                ),
                "content" => new EmailContent(
                    array(
                        "body" => array(
                            new BodyPart(
                                array(
                                    "content_type" => "HTML",
                                    "content" => $htmlContent
                                )
                            )
                        ),
                        "from" => "bytebuddylearning@gmail.com",
                        "subject" => $subject,
                        "name" => "ByteBuddy Learning"
                    )
                ),
                "isTransactional" => false,
            )
        );

        try {
            if ($apiInstance->emailsPost($email)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Exception when calling EE API: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function sendEmailWithPdf($email, $subject, $pdfContent)
    {
        $htmlContent = '<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <title>Nuevo Curso Adquirido</title>
            </head>
            <body>
                <h1>Has adquirido un nuevo curso</h1>
                <p>Este es un correo electrónico generado automáticamente. Por favor, no responder.</p>
            </body>
            </html>';

        $apiInstance = new EmailsApi(
            new Client(),
            $this->config
        );

        $email = new EmailMessageData(
            array(
                "recipients" => array(
                    new EmailRecipient(array("email" => $email))
                ),
                "content" => new EmailContent(
                    array(
                        "body" => array(
                            new BodyPart(
                                array(
                                    "content_type" => "HTML",
                                    "content" => $htmlContent
                                )
                            )
                        ),
                        "from" => "bytebuddylearning@gmail.com",
                        "subject" => $subject,
                        "name" => "ByteBuddy Learning"
                    )
                ),
                "attachments" => array(
                    array(
                        "content" => base64_encode($pdfContent),
                        "content_type" => "application/pdf",
                        "name" => "curso.pdf"
                    )
                ),
                "isTransactional" => false,
            )
        );

        try {
            if ($apiInstance->emailsPost($email)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Exception when calling EE API: ', $e->getMessage(), PHP_EOL;
        }
    }
}