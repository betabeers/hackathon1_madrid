<?php

/*
 * This file is part of the Instabook package.
 * 
 * Description of Book
 *
 * @author Daniel Gonzalez <daniel.gonzalez@freelancemadrid.es>
 * @file Book.php
 * @date 28 - Apr - 2012
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Book
{
    public $link = null;
    public $title = null;
    public $description = null;
    public $image = null;
    public $google_id = null;
    public $vote = 0;
    public $n_vote = 0;
    public $category = null;
    public $author = null;
    public $isbn_10 = null;
    public $isbn_13 = null;

    public function save()
    {
        BooksParseService::getInstance()->save($this);
    }

    public function nVote()
    {
        $this->n_vote++;
        $this->save();
    }

    public function vote()
    {
        $this->vote++;
        $this->save();
    }

    public function toArray()
    {
        $array = array();
        foreach ($this as $key => $value)
        {
            $array[$key] = $value;
        }
        unset($array["createdAt"], $array["updatedAt"], $array["objectId"]);
        return $array;
    }

    public function __construct($google_id = null)
    {
        if ($google_id)
        {
            $this->google_id = (string) $google_id;
            BooksService::getInstance()->get($this->google_id);
            if ($response = BooksParseService::getInstance()->get($this->google_id))
            {
                foreach ($response as $key => $value)
                {
                    $this->$key = $value;
                }
            }
        }
    }

}
