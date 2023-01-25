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

namespace Application\Service;

use Application\Model\Collection\OptionCollection;
use Application\Model\Catalog\OptionCatalog;
use Application\Model\Bean\Option;
use Application\Query\OptionQuery;

/**
 *
 * OptionService
 *
 * @option Application\Service
 * @author guadalupe, chente
 */
class OptionService extends AbstractService
{

    /**
     * @var \Application\Model\Catalog\OptionCatalog
     */
    protected $optionCatalog;

    /**
     * Obtiene una opcion
     * @param int $idOption
     * @return Option
     */
    public function getById($idOption)
    {
        $option = OptionQuery::create()
            ->findByPKOrThrow($idOption, $this->getI18n()->_("The parameter with ID does not exist: ") . $idOption);

        $this->wrapper($option);

        return $option;
    }

    /**
     * Obtiene las opciones por criteria
     */
    public function wrappperCollection(OptionCollection $options)
    {
        $self = $this;
        $options->each(function(Option $option) use($self){
            $self->wrapper($option);
        });
    }

    /**
     * Actualiza una opcion
     * @param Option $option
     * @param mixed $value
     */
    public function update(Option $option, $value)
    {
        if( null === $value ){
            throw new \Exception($this->getI18n()->_('The value can not be empty'));
        }

        $errorMessage = $this->getI18n()->_('The value is invalid: ');
        switch ($option->getType())
        {
            case Option::$Types['Simple'] :
                if( !preg_match($option->getRegexp(), $value)){
                    throw new \Exception($errorMessage);
                }
                $option->setValue($value);
                break;
            case Option::$Types['Multiple'] :
                foreach ($value as $v){
                    if( !preg_match($option->getRegexp(), $v) ){
                        throw new \Exception($errorMessage);
                    }
                }

                $json = json_encode(array_map('utf8_encode', $value));

                $option->setValue($json);
                break;
            case Option::$Types['Yes_No'] :
                $option->setValue( $value ? 1 : 0 );
                break;
            case Option::$Types['Select'] :
                $json = json_encode(array_map('utf8_encode', $option->getOptions()));
                $option->setOptions($json);
                $option->setValue($value);
                break;
        }
        $this->getOptionCatalog()->update($option);
    }

    /**
     * Realiza los cambios pertinentes dependiendo del tipo
     * @param Option $option
     */
    public function wrapper(Option $option)
    {
        switch ($option->getType())
        {
            case Option::$Types['Multiple']:
                $values = array_map('utf8_decode', json_decode($option->getValue()));
                $option->setValue($values);
                break;
            case Option::$Types['Yes_No']:
                $option->setValue( (bool) $option->getValue() );
                break;
            case Option::$Types['Select']:
                $options =  (array) json_decode($option->getOptions());
                $option->setOptions(array_map('utf8_decode', $options));
                break;
        }
    }


    /**
     * @param OptionCatalog $optionCatalog
     */
    public function setOptionCatalog(OptionCatalog $optionCatalog){
        $this->optionCatalog = $optionCatalog;
    }

    /**
     * @return \Application\Model\Catalog\OptionCatalog
     */
    public function getOptionCatalog(){
        return $this->optionCatalog;
    }

}