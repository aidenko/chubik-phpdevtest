<?php

namespace Aidenko\ChubikPhpdevtest;

/**
 * Class Response
 *
 * @package Aidenko\ChubikPhpdevtest
 *
 * @property string $status
 * @property string $message
 * @property array $authors
 * @property array $books
 * @property int $limit
 * @property int $offset
 * @property int $rows
 * @property int $results
 *
 * @method string status()
 * @method string message()
 * @method array authors()
 * @method array books()
 * @method int limit()
 * @method int offset()
 * @method int rows()
 *
 */

class Response
{
    protected $_response = null;

    function __construct($response)
    {
        if (is_object($response)) {
            $this->_response = $response;
        } else {
            $this->_response = new \stdClass();
        }
    }

    public function __get($param)
    {
        if (isset($this->_response->{$param})) {
            return $this->_response->{$param};
        } elseif (isset($this->_response->data) && isset($this->_response->data->{$param})) {
            return $this->_response->data->{$param};
        } elseif (method_exists($this, $param)) {
            return call_user_func_array([$this, $param], []);
        } else {
            return null;
        }
    }

    public function __call($method, $arguments)
    {
        return $this->{$method};
    }

    public function isFine()
    {
        return strtolower($this->status) == 'ok';
    }

    public function results()
    {
        $results = 0;

        if (is_array($this->authors)) {
            $results = count($this->authors);
        } elseif (is_array($this->books)) {
            $results = count($this->books);
        }

        return $results;
    }
}