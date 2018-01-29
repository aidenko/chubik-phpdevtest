<?php

namespace Aidenko\ChubikPhpdevtest;

use Httpful\Exception\ConnectionErrorException;
use Httpful\Mime;
use Httpful\Request;

/**
 * Class Query
 *
 * @package Aidenko\ChubikPhpdevtest
 */
class Query
{
    /**
     * @var string
     */
    protected $default_path = '';

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var string
     */
    protected $default_query = '';

    /**
     * @var string
     */
    protected $query = '';

    /**
     * Query constructor.
     *
     * @param \Aidenko\ChubikPhpdevtest\Config $config
     */
    function __construct(Config $config)
    {
        $this->config = $config;

        $this->resetPath();
        $this->resetQuery();
    }

    /**
     * @return \Aidenko\ChubikPhpdevtest\Query
     */
    public function books()
    {
        $this->path .= '/books';

        return $this;
    }

    /**
     * @param null $author_id
     * @return \Aidenko\ChubikPhpdevtest\Query
     */
    public function authors($author_id = null)
    {
        $this->path .= '/authors';

        if (is_numeric($author_id)) {
            $this->path .= '/'.$author_id;
        }

        return $this;
    }

    /**
     * @param $limit
     * @param null $offset
     * @return \Aidenko\ChubikPhpdevtest\Query
     */
    public function limit($limit, $offset = null)
    {
        if (is_numeric($limit)) {
            $this->query .= '?limit='.$limit;
        }

        if (is_numeric($offset)) {
            $this->query .= (empty($this->query) ? '?' : '&').'offset='.$offset;
        }

        return $this;
    }

    /**
     * @return \Aidenko\ChubikPhpdevtest\Response
     */
    public function get()
    {
        $url = $this->config->host();

        if (is_numeric($this->config->port())) {
            $url .= ':'.$this->config->port();
        }

        try {
            $result = Request::get($url.$this->path.$this->query)->expects(Mime::JSON)->send()->body;
        } catch (ConnectionErrorException $e) {
            $result = new \stdClass();
        }

        $this->resetPath();
        $this->resetQuery();

        return new Response($result);
    }

    /**
     *
     */
    protected function resetPath()
    {
        $this->path = $this->default_path;
    }

    /**
     *
     */
    protected function resetQuery()
    {
        $this->query = $this->default_query;
    }
}