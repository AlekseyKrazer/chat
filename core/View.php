<?php
namespace core;
/**
 * Class View
 */
class View
{
    /**
     * @param $content
     * @param null $data
     */
    public function generate($content, $data = null)
    {
        include 'views/'.$content;
    }
}