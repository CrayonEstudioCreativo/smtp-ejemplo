<?php
namespace CrayonEstudioCreativo\Tutorial;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\Yaml\Yaml;

class LibreriaSMTP {

  const INVALIDO = 'invalid_data';
  const SUCCESS = 'success';

  private $config = array();

  public function __construct($path) {
    if (!file_exists($path)) {
      throw new \Exception("El archivo de configuracion del servidor no está bien definido");
    }
    $this->config = Yaml::parse(file_get_contents($path));
  }

  /**
   * Esta funcion limpia las variables ingresadas que buscamos por $_POST.
   * @return mixed
   */
  private function getFilteredPost() {
    $args = array(
      'email'   => array(
        'filter' => FILTER_SANITIZE_EMAIL,
      ),
      'mensaje' => array(
        'filter' => FILTER_SANITIZE_STRING,
      ),
    );

    return filter_input_array(INPUT_POST, $args);
  }

  /**
   * Retorna un Mailer para un transport de SMTP de SwiftMailer.
   * @return \Swift_Mailer
   */
  private function createMailer() {
    $smtp_host_ip = gethostbyname($this->config['smtp']);
    $transport    = Swift_SmtpTransport::newInstance($smtp_host_ip, $this->config['port'], $this->config['security'])
                                       ->setUsername($this->config['username'])
                                       ->setPassword($this->config['password']);
    $transport->start();

    return Swift_Mailer::newInstance($transport);
  }

  public function sendMail() {
    $variables = $this->getFilteredPost();

    if (empty($variables['email']) || empty($variables['mensaje'])) {
      header('Location: /?status=' . md5(LibreriaSMTP::INVALIDO));
    }

    $email   = $variables['email'];
    $mensaje = $variables['mensaje'];

    $mailer = $this->createMailer();

    $message = Swift_Message::newInstance();
    $message->setSubject('Te han enviado un correo')
            ->setFrom($this->config['from'])
            ->setTo($this->config['to'])
            ->setBody($message, 'text/html', 'utf-8');

    if ($mailer->send($message)) {
      header("/?status=" . md5(LibreriaSMTP::SUCCESS));
    }
    else {
      header("/?status=" . md5(LibreriaSMTP::INVALIDO));
    }

    die();

  }
}