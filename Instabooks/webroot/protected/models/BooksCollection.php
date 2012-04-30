<?php

/*
 * This file is part of the Instabook package.
 * 
 * Description of BooksCollection
 *
 * @author Daniel Gonzalez <daniel.gonzalez@freelancemadrid.es>
 * @file BooksCollection.php
 * @date 28 - Apr - 2012
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class BooksCollection
{

    /**
     *
     * @var array 
     */
    private $books = array();

    /**
     * Add book to collection
     * 
     * @param Book $book 
     */
    public function add(Book $book)
    {
        array_push($this->books, $book);
    }

    /**
     * Retrieve books Collection as array
     *  
     * @return array 
     */
    public function toArray()
    {
        return $this->books;
    }

    /**
     * Retrieve number of items in collection
     * 
     * @return int 
     */
    public function count()
    {
        return count($this->books);
    }

}
