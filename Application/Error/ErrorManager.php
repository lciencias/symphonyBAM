<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Project
 * @package    Lib_Error
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

namespace Application\Error;

use Application\Smarty\ZendSmarty;

/**
 * Clase ErrorManager
 *
 * @category   Project
 * @package    Lib_Error
 * @copyright  ##$COPYRIGHT$##
 */
class ErrorManager
{

    /**
     * ZendSmarty
     * @var ZendSmarty
     */
    private $view;

    /**
     * Exception
     * @var Exception
     */
    private $exception;

    /**
     * ArrayObject
     * @var ArrayObject
     */
    private $errorHandler;

    /**
     *
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     *
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    /**
     * Class Constructor
     * @param ZendSmarty $view
     * @param \Zend_Controller_Request_Abstract $request
     * @param \Zend_Controller_Response_Abstract $response
     * @return ErrorManager
     */
    public function __construct(ZendSmarty $view,
    \Zend_Controller_Request_Abstract $request,  \Zend_Controller_Response_Abstract $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
        $this->errorHandler = $request->getParam('error_handler');
        $this->exception = $this->errorHandler->exception;
    }

    /**
     *
     * @param unknown_type $header
     */
    private function setRawHeader($header)
    {
        $this->response->setRawHeader($header);
    }

    /**
     * Despliega la página de 404 documento no encontrado
     */
    private function displayNotFound()
    {
        $this->setRawHeader('HTTP/1.1 404 Not Found');
        $this->view->setTpl('NotFound');
        $this->view->contentTitle = 'Not Found';
        $this->view->message = $this->exception->getMessage();
    }

    /**
     * Despliega la página de Forbidden
     */
    private function displayUnauthorized()
    {
        $this->setRawHeader('HTTP/1.1 401 Unauthorized');
        $this->view->setTpl('Unauthorized');
        $this->view->contentTitle = 'Unauthorized';
        $this->view->message = $this->exception->getMessage();
    }

    /**
     * Despliega la página de Error de Servidor
     */
    private function displayInternalServerError()
    {
        //$this->view->contentTitle = 'Internal Server Error';
        $this->setRawHeader('HTTP/1.1 500 Internal Server Error');
        if( $this->request->isXmlHttpRequest() )
        {
            $this->view->setTpl('_error')->setLayoutFile(false);
            $this->view->message = $this->exception->getMessage();
        }else
        {
            $this->view->message = $this->exception->getMessage();
            $this->view->trace = $this->getFormatedTrace($this->exception->getTraceAsString());
            $this->view->type = get_class($this->exception);
            $this->view->queries = $this->getDbAdapter()->getProfiler()->getQueryProfiles();

            $file = $this->exception->getFile();
            $line = $this->exception->getLine();
            $this->view->file = $file;
            $this->view->line = $line;
            $source = $this->getCode($file,$line);
            $this->view->source = $source;
        }
    }

    /**
     * @return \Zend_Db_Adapter_Abstract
     */
    private function getDbAdapter(){
        return \Zend_Registry::getInstance()->get('container')->get('dbao')->getDbAdapter();
    }

    /**
     * Obtiene el codigo de un archivo
     * @param string $file
     * @param int $line
     * @param int $lines
     */
    private function getCode($file,$line,$lines = 10)
    {
        $fileContent = highlight_file($file, true);
        $fileContent = str_replace('<br />', "<br />\n", $fileContent);
        $fileContent = explode("\n", $fileContent);

        $startsOn = (($line - $lines) < 0) ? 0 : ($line - $lines);
        $endsOn = $line + $lines;

        $content = "";
        for($i = $startsOn; $i <= $endsOn; $i++)
        {
            if ($line == $i)
                $content .= '<div style="background-color:#FFdd00;width:100%;">' . $i . ' ' . $fileContent[$i] . "</div>";
            else $content .= $i . ' ' . $fileContent[$i];
            if ($i == count($fileContent) - 1) break;
        }
        return $content;
    }

    /**
     * Obtiene el trace
     */
    private function getFormatedTrace($trace)
    {
        return nl2br($trace);
    }

    /**
     * Muestra el mensaje de error
     */
    public function dispatch()
    {
        $this->view->setTpl('Error');
        $this->view->contentTitle = 'Error';

        switch($this->errorHandler->type)
        {
            case \Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case \Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                $this->displayNotFound();
                break;
            default:
                if( $this->errorHandler->exception instanceof AuthException )
                $this->displayUnauthorized();
            else if( $this->errorHandler->exception instanceof Zend_Acl_Exception )
                $this->displayNotFound();
            else
                $this->displayInternalServerError();
            break;
        }
    }

}
