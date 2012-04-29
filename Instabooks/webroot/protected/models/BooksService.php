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

class BooksService
{

    private $goole_rest_api_search = null;
    private $collection = null;
    private static $instances = array();
    private $parse = null;

    protected function initialize()
    {
        $this->goole_rest_api_search = 'https://www.googleapis.com/books/v1/volumes';
        $this->collection = new BooksCollection();
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

    public function get($id)
    {
        @ $result = json_decode(file_get_contents($this->goole_rest_api_search . '/' . urlencode($id)));
        if ($result)
        {
            $item=$result;
                $book = new Book();
                if (isset($item->selfLink))
                {
                    $book->link = $item->selfLink;
                }
                if(isset($item->id)){
                    $book->google_id = $item->id;
                }
                if (isset($item->volumeInfo->title))
                {
                    $book->title = $item->volumeInfo->title;
                }
                if (isset($item->volumeInfo->subtitle))
                {
                    $book->title .= ' : ' . $item->volumeInfo->subtitle;
                }
                if (isset($item->volumeInfo->description))
                {
                    $book->description = $item->volumeInfo->description;
                }
                if (isset($item->volumeInfo->authors[0]))
                {
                   $book->author = $item->volumeInfo->authors[0];
                }
                if (isset($item->industryIdentifiers->categories[0]))
                {
                    $book->category = $item->industryIdentifiers->categories[0];
                }
                if(isset($item->accessInfo->webReaderLink)){
                    $book->web_reader_link = $item->accessInfo->webReaderLink;
                }
                @ $book_info_result = json_decode(file_get_contents($item->selfLink));
                if ($book_info_result)
                {
                    if (isset($book_info_result->volumeInfo->imageLinks->thumbnail))
                    {
                        $book->image = $book_info_result->volumeInfo->imageLinks->thumbnail;
                    }
                }
                if (!BooksParseService::getInstance()->get($book->google_id))
                {
                    $book->save();
                }
                return $book;
        }
        return null;
    }

    public function search($query)
    {
        @ $result = json_decode(file_get_contents($this->goole_rest_api_search . '?q=' . urlencode($query)));
        if ($result)
        {
            foreach ($result->items as $item)
            {
                $book = new Book();
                if (isset($item->selfLink))
                {
                    $book->link = $item->selfLink;
                }
                if (isset($item->id))
                {
                    $book->google_id = $item->id;
                }
                if (isset($item->volumeInfo->title))
                {
                    $book->title = $item->volumeInfo->title;
                }
                if (isset($item->volumeInfo->subtitle))
                {
                    $book->title .= ' : ' . $item->volumeInfo->subtitle;
                }
                if (isset($item->volumeInfo->description))
                {
                    $book->description = $item->volumeInfo->description;
                }
                if (isset($item->volumeInfo->authors[0]))
                {
                    $book->author = $item->volumeInfo->authors[0];
                }
                if (isset($item->industryIdentifiers->categories[0]))
                {
                    $book->category = $item->industryIdentifiers->categories[0];
                }
                if (isset($item->accessInfo->webReaderLink))
                {
                    $book->web_reader_link = $item->accessInfo->webReaderLink;
                }
                if (isset($item->volumeInfo->industryIdentifiers[0]->identifier))
                {
                    $book->isbn_10 = $item->volumeInfo->industryIdentifiers[0]->identifier;
                }
                if (isset($item->volumeInfo->industryIdentifiers[1]->identifier))
                {
                    $book->isbn_13 = $item->volumeInfo->industryIdentifiers[1]->identifier;
                }
                @ $book_info_result = json_decode(file_get_contents($item->selfLink));
                if ($book_info_result)
                {
                    if (isset($book_info_result->volumeInfo->imageLinks->thumbnail))
                    {
                        $book->image = $book_info_result->volumeInfo->imageLinks->thumbnail;
                    }
                }
                $this->collection->add($book);
            }
        }
        return $this->collection;
    }

}
