<?php

class Episodes extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $air_date;

    /**
     *
     * @var string
     */
    public $episode;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var integer
     */
    public $characters;

    /**
     *
     * @var string
     */
    public $url;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("rickyandmorty");
        $this->setSource("episodes");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Episodes[]|Episodes|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Episodes|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
