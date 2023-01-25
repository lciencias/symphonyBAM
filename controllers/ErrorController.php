<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

use Application\Controller\BaseController;
use Application\Error\ErrorManager;

/**
 * Clase ErrorController, que se encarga de mostrar los errores en pantalla
 *
 * @category   project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 */
class ErrorController extends BaseController
{
    /**
     * Sobrecargamos la función init para que no pida autentificación
     */
    public function init()
    {
        $this->initI18n();
        $this->toView();
    }

    /**
     * Muestra el Error
     */
    public function errorAction()
    {
        $errorManager = new ErrorManager($this->view, $this->getRequest(), $this->getResponse());
        $errorManager->dispatch();
    }
}
