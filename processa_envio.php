<?php

    require "./bibliotecas/PHPMailer/Exception.php";
    require "./bibliotecas/PHPMailer/OAuth.php";
    require "./bibliotecas/PHPMailer/PHPMailer.php";
    require "./bibliotecas/PHPMailer/POP3.php";
    require "./bibliotecas/PHPMailer/SMTP.php";

    // pega o namepsace e as classes que estão dentro da biblioteca
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

//print_r($_POST);

class Mensagem
{
    private $para = null;
    private $assunto = null;
    private $mensagem = null;

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function mensagemValida()
    {
        // se algo tiver vazio...
        if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
            return false;
        }
        return true;
    }
}
$mensagem = new Mensagem();

// isso só funciona porque coloquei os names lá no index.php
// o valor vem da $_POST do índice ['para]...['assunto']... etc, os índices são definidos pelos names dos campos
// então isso recupera os valores
// dentro do parenteses vem os atributos do objeto mensagem e depois do post os valores dos respectivos atributos
$mensagem->__set('para', $_POST['para']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

if (!$mensagem->mensagemValida()) {
    echo 'Mensagem  não é valida'; 
    die(); // mata o procesamento de scripts daqui pra frente caso seja falso.
} 

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'user@example.com';                 // SMTP username
    $mail->Password = 'secret';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}

