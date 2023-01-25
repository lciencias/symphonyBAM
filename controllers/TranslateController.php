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

use Application\Model\Catalog\TranslateCatalog;
use Application\Model\Factory\TranslateFactory;
use Application\Model\Bean\Translate;
use Application\Query\TranslateQuery;
use Application\Query\UserQuery;
use Application\Query;
use Application\Controller\BaseController;

/**
 *
 * @author chente
 */
class TranslateController extends BaseController
{

    /**
     * @module Translate
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Translate
     * @action List
     * @return array
     */
    public function listAction(){
        $this->view->translates = $translates = TranslateQuery::create()->find();
    }

    /**
     * @module Translate
     * @action Save
     * @return array
     */
    public function updateAction()
    {
        $stringsInEnglish = $this->getRequest()->getParam('en', array());
        $stringsInSpanish = $this->getRequest()->getParam('es', array());

        try
        {
            $this->getTranslateCatalog()->beginTransaction();

            foreach ($stringsInEnglish as $idTranslate => $en){
                $translate = TranslateQuery::create()->findByPKOrThrow($idTranslate, "The translate not exists");
                $translate->setEn($en);
                $translate->setEs($stringsInSpanish[$idTranslate]);
                $this->getTranslateCatalog()->update($translate);
            }

            $this->deleteCache();

            $this->getTranslateCatalog()->commit();
        }
        catch (Exception $e) {
            $this->getTranslateCatalog()->rollBack();
            throw $e;
        }

        $this->_redirect('translate/list');
    }

    /**
     * @module Translate
     * @action Delete
     * @return array
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $translate = TranslateQuery::create()->findByPKOrThrow($id, $this->i18n->_("The Translate not exists"));
        $this->getTranslateCatalog()->deleteById($translate->getIdTranslate());
        $this->deleteCache();
        $this->_redirect('translate/list');
    }

    /**
     * @module Translate
     * @action Inspect
     * @return array
     */
    public function inspectAction()
    {
        $strings = array();
        $strings = array_merge($strings, array_values(Query\AreaQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\CategoryQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\ChannelQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\ImpactQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\LocationQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\PositionQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\PriorityQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\ResolutionQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\ServiceLevelQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\TicketTypeQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\EscalationQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\WorkweekQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\GroupQuery::create()->find()->toCombo()));
        $strings = array_merge($strings, array_values(Query\AccessRoleQuery::create()->find()->toCombo()));

        $strings = array_unique($strings);

        try
        {
            $this->getTranslateCatalog()->beginTransaction();

            foreach ($strings as $string){

                $translate = TranslateQuery::create()->whereAdd(Translate::STRING, $string)->setLimit(1)->findOne();

                if( !($translate instanceof Translate) ){
                    $translate = TranslateFactory::createFromArray(array(
                        'string' => $string,
                        'en' => $string,
                        'es' => $string,
                    ));
                    $this->getTranslateCatalog()->create($translate);
                }
            }

            $this->deleteCache();

            $this->getTranslateCatalog()->commit();
        }
        catch (Exception $e) {
            $this->getTranslateCatalog()->rollBack();
            throw $e;
        }

        $this->_redirect('translate/list');
    }

    /**
     *
     */
    private function deleteCache(){
        $this->getContainer()->get('master_translator')->getStorage()->removeAll();
    }

    /**
     * @return \Application\Model\Catalog\TranslateCatalog
     */
    private function getTranslateCatalog(){
        return $this->getCatalog('TranslateCatalog');
    }

}
