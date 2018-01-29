<?php

namespace Aidenko\ChubikPhpdevtest;

/**
 * Class Api
 *
 * @package Aidenko\ChubikPhpdevtest
 *
 * @method Query authors()
 * @method Query books()
 * @method Query limit()
 *
 */

class Api
{
    /**
     * @var \Aidenko\ChubikPhpdevtest\Query|null
     */
    protected $__query = null;

    /**
     * Api constructor.
     *
     * @param \Aidenko\ChubikPhpdevtest\Config $config
     */
    function __construct(Config $config)
    {
        $this->__query = new Query($config);
    }

    /**
     * @param $name
     * @param $arguments
     * @return \Aidenko\ChubikPhpdevtest\Query
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->query(), $name)) {
            return call_user_func_array([$this->query(), $name], $arguments);
        }
    }

    /**
     * @param $author_id
     * @return \Aidenko\ChubikPhpdevtest\Query
     */
    public function authorBooks($author_id)
    {
        return $this->query()->authors($author_id)->books();
    }

    /**
     * @return \Aidenko\ChubikPhpdevtest\Query
     */
    protected function query()
    {
        return $this->__query;
    }
}