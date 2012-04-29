<?php

require_once(dirname(__FILE__) . '/BooksCollection.php');
require_once(dirname(__FILE__) . '/Book.php');
require_once(dirname(__FILE__) . '/../vendors/parse.php');

/*
 * This file is part of the Instabook package.
 * 
 * Description of BooksService
 *
 * @author Daniel Gonzalez <daniel.gonzalez@freelancemadrid.es>
 * @file BooksService.php
 * @date 28 - Apr - 2012
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class BooksParseService
{

    private static $instances = array();
    private $parse = null;

    protected function initialize()
    {
        $this->parse = new parseRestClient(array(
                    'appid' => 'u5H31glPx0jAhIpud6NhnEMzCQhEEIPgH5yk10fm',
                    'restkey' => 'sBPGrYzBu2HKwZ6bCsg2HAGwBlj5rRDpjzXuuAwo'
                ));
    }

    final public static function getInstance()
    {

        $class = get_called_class();
        if (!isset(self::$instances[$class]))
        {
            self::$instances[$class] = new $class();
        }
        return self::$instances[$class];
    }

    public function __construct()
    {
        if (isset(self::$instances[get_called_class()]))
        {
            throw new Exception(" A " . get_called_class() . " instance already exist");
        }
        $this->initialize();
    }

    public function search($query)
    {
        
    }

    public function get($google_id = null)
    {
        $params = array(
            'className' => 'Books',
            'object' => array(),
            'query' => array(
                'google_id' => $google_id
            ),
            'limit' => 1,
        );       
        $response = json_decode($this->parse->query($params));
        if ($response && isset($response->results) && count($response->results))
        {
            return $response->results[0];
        } else
        {
            return false;
        }
    }

    public function save(Book $book)
    {
        if ($response = $this->get($book->google_id))
        {            
            $params = array(
                'className' => 'Books',
                'objectId' => $response->objectId,
                'object' => $book->toArray(),
            );
            $this->parse->update($params);
        } else
        {
            $params = array(
                'className' => 'Books',
                'object' => $book->toArray(),
            );
            $this->parse->create($params);
        }
    }

}
