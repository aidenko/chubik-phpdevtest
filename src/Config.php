<?php

namespace Aidenko\ChubikPhpdevtest;

/**
 * Class Config
 *
 * @package Aidenko\ChubikPhpdevtest
 */
class Config
{
    /**
     * @var mixed|null
     */
    protected $_host = null;

    /**
     * @var int|null|string
     */
    protected $_port = null;

    /**
     * Config constructor.
     *
     * @param $host
     * @param null $port
     * @throws \Exception
     */
    function __construct($host, $port = null)
    {
        $_host = filter_var($host, FILTER_SANITIZE_URL);

        if (! empty($_host) && filter_var($_host, FILTER_VALIDATE_URL) !== false) {
            $this->_host = $_host;
        } else {
            throw new \Exception("Incorrect host: [".$host.']');
        }

        if (is_numeric($port)) {
            $this->_port = $port;
        }
    }

    /**
     * @return string|null
     */
    public function host()
    {
        return $this->_host;
    }

    /**
     * @return int|null|string
     */
    public function port()
    {
        return $this->_port;
    }
}