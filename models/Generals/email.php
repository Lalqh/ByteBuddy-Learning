<?php

require __DIR__ . '/../../vendor/autoload.php';

class Email
{
    private $config;
    public function __construct()
    {
        $this->config = ElasticEmail\Configuration::getDefaultConfiguration()
            ->setApiKey(
                'X-ElasticEmail-ApiKey',
                'E4F36ECA4F5B0D5AE51DEC6B9BC1B7C934674EC87DAEF408E86378AC66454F00D188498141BE78159BBC736B6DE6CD27'
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

        $apiInstance = new ElasticEmail\Api\EmailsApi(
            new GuzzleHttp\Client(),
            $this->config
        );

        $email = new \ElasticEmail\Model\EmailMessageData(
            array(
                "recipients" => array(
                    new \ElasticEmail\Model\EmailRecipient(array("email" => $email))
                ),
                "content" => new \ElasticEmail\Model\EmailContent(
                    array(
                        "body" => array(
                            new \ElasticEmail\Model\BodyPart(
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
}