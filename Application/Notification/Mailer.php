<?php

/**
 * PCS Mexico
 *
 * SIDI
 *
 * @category   project
 * @package    Mail
 * @copyright  Copyright (c) 2007-2009 PCS Mexico (http://www.pcsmexico.com)
 * @author     Vicente Mendoza Moreno
 * @version    1.0
 */

namespace Application\Notification;

/**
 * dependences
 */
require_once 'Swift/swift_required.php';

/**
 * Clase ZendMailer
 *
 * @category   project
 * @package    Project_Notification
 * @copyright  Copyright (c) 2007-2011 PCS Mexico (http://www.pcsmexico.com)
 * @author     Vicente Mendoza Moreno
 */
class Mailer extends \Swift_Mailer
{

    /**
     *
     * @var \Zend_Config
     */
    protected $webconfig;

    /**
     * Creates a new message.
     *
     * @param string|array $from    The from address
     * @param string|array $to      The recipient(s)
     * @param string       $subject The subject
     * @param string       $body    The body
     *
     * @return Swift_Message A Swift_Message instance
     */
    public function compose( $to = null, $subject = null, $body = null, $bodyType = 'text/html', $charset = 'iso-8859-1')
    {
        return \Swift_Message::newInstance()
            ->setFrom( $this->getConfigMailer('fromMail'), $this->getConfigMailer('fromName') )
            ->setTo( $to )
            ->setSubject( $subject )
            ->setBody( $body, $bodyType, $charset);
    }

    public function composeAttached( $to = null, $subject = null, $body = null, $attached= null, $bodyType = 'text/html', $charset = 'iso-8859-1')
    {
   		return \Swift_Message::newInstance()
            ->setFrom( $this->getConfigMailer('fromMail'), $this->getConfigMailer('fromName') )
            ->setTo( $to )
            ->setSubject( $subject )
            ->setBody( $body, $bodyType, $charset)
        	->attach(\Swift_Attachment::fromPath($attached));
    }
    /**
     *
     * @param \Swift_Transport $transport
     */
    public function __construct(\Zend_Config $webconfig)
    {
        $this->setWebconfig($webconfig);

        if( null === $transport ){
            $transport = $this->createTransport();
        }

        parent::__construct($transport);
        \Swift_Preferences::getInstance()->setCharset('iso-8859-1');
    }

    /**
     * Sends a message.
     *
     * @param string|array $to      The recipient(s)
     * @param string       $subject The subject
     * @param string       $body    The body
     * @return int The number of sent emails
     */
    public function composeAndSend($to, $subject, $body)
    {
        return $this->send( $this->compose( $to, $subject, $body ) );
    }
    
    public function composeAndSendAttachement($to, $subject, $body, $attached){    	
    	return $this->send( $this->composeAttached( $to, $subject, $body, $attached ) );
    }

    /**
     * Iniciliza el transport
     */
    protected function createTransport()
    {
        $configMailer = $this->getWebconfig()->mailer;

        return \Swift_SmtpTransport::newInstance($configMailer->host, $configMailer->port, $configMailer->security)
            ->setUsername($configMailer->user)
            ->setPassword($configMailer->password);
    }

    /**
     *
     * @param Zend_Config $webconfig
     */
    public function setWebconfig($webconfig){
        $this->webconfig = $webconfig;
    }

    /**
     *
     * @param unknown_type $parameter
     */
    private function getConfigMailer($parameter){
        return $this->getWebconfig()->mailer->get($parameter);
    }

    /**
     *
     */
    public function getWebconfig(){
        return $this->webconfig;
    }

}