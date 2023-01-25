<?php
/**
 * PCS Mexico
 *
 * Symphony Help Desk
 *
 * @copyright Copyright (c) PCS Mexico (http://pcsmexico.com)
 * @author    guadalupe, chente, $LastChangedBy$
 * @version   2
 */

use Application\Model\Catalog\CalendarCatalog;
use Application\Model\Factory\CalendarFactory;
use Application\Model\Bean\Calendar;
use Application\Query\CalendarQuery;
use Application\Form\CalendarForm;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class CalendarController extends CrudController
{

    /**
     * @module Holiday
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Holiday
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        $total = CalendarQuery::create()->holiday()->count();
        $this->view->calendars = $calendars = CalendarQuery::create()
            ->holiday()
            ->page($page, $this->getMaxPerPage())
            ->addDescendingOrderBy(Calendar::DATE)
            ->find();

        $this->view->paginator = $this->createPaginator($total, $page);
    }

    /**
     * @module Holiday
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('calendar', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Holiday
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $calendar = $this->findByID($id);

        $url = $this->generateUrl('calendar', 'update', compact('id'));
        $form = $this->getForm(false)
            ->populate($calendar->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Holiday
     * @action Create
     * @return array
     */
    public function createAction()
    {
        $form = $this->getForm();
        if( $this->getRequest()->isPost() ){

           $params = $this->getRequest()->getParams();
           $date = $this->getRequest()->getParam('date');
           if( !$form->isValid($params) ){
               $this->view->setTpl("New");
               $this->view->form = $form;
               return;
           }

           try
           {
               $this->getCalendarCatalog()->beginTransaction();

               $calendar = CalendarQuery::create()->whereAdd(Calendar::DATE, $date)
                   ->findOneOrThrow($this->i18n->_("The date for the calendar not exists: ") . $date);
               $calendar->setNameHoliday($this->getRequest()->getParam('name_holiday'));
               $calendar->setIsHoliday(true);
               $this->getCalendarCatalog()->update($calendar);

               $this->getCalendarCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Calendar was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getCalendarCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('calendar/list');
    }

    /**
     * @module Holiday
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        $form = $this->getForm(false);
        if( $this->getRequest()->isPost() ){

            $params = $this->getRequest()->getParams();
            if( !$form->isValid($params) ){
                $this->view->setTpl("New");
                $this->view->form = $form;
                return;
            }

            $id = $this->getRequest()->getParam('id');
            $calendar = $this->findByID($id);

            try
            {
                $this->getCalendarCatalog()->beginTransaction();

                CalendarFactory::populate($calendar, $form->getValues());
                $this->getCalendarCatalog()->update($calendar);

                $this->getCalendarCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Calendar was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getCalendarCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('calendar/list');
    }

    /**
     * @module Holiday
     * @action Delete
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $calendar = $this->findByID($id);

        try
        {
            $this->getCalendarCatalog()->beginTransaction();

            $calendar->setIsHoliday(false);
            $calendar->setNameHoliday("");
            $this->getCalendarCatalog()->update($calendar);

            $this->getCalendarCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Calendar was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getCalendarCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('calendar/list');
    }

    /**
     *
     * @param int $id
     * @return Calendar
     */
    private function findByID($id){
        return CalendarQuery::create()
            ->findByPKOrThrow($id, $this->i18n->_("Not exists the Calendar with id: "). $id);
    }

    /**
     * @return \Application\Model\Catalog\CalendarCatalog
     */
    protected function getCalendarCatalog(){
        return $this->getContainer()->get('CalendarCatalog');
    }

    /**
     *
     * @return Application\Form\CalendarForm
     */
    protected function getForm($isNew = true)
    {
        $form = new CalendarForm();
        $submit = new Zend_Form_Element_Submit("send");
        $submit->setLabel($this->i18n->_("Save"));
        $cancel = new Zend_Form_Element_Button('cancel');
        $cancel->setLabel($this->i18n->_("Cancel"));
        $form->addElement($submit)
            ->addElement($cancel)
            ->setMethod('post');

        $form->twitterDecorators();
        if( !$isNew ) {
            $form->getFor('date')->setRequired(false);
            $form->getFor('date')->clearValidators();
            $form->getFor('date')->setAttrib('disabled', 'disabled');
        }
        return $form;
    }

}
