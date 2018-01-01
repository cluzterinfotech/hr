<?php
/**
 * ZfTable ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License 
 */


namespace ZfTable\Decorator\Cell;

use ZfTable\Decorator\Exception;

class Link extends AbstractCellDecorator
{

    /**
     * Array of variable attibute for link
     * @var array
     */
    protected $vars;

    /**
     * Link url
     * @var string
     */
    protected $url;
    
    protected $txt;

    
    /**
     * Constructor
     * @param array $options
     * @throws Exception\InvalidArgumentException
     */
    public function __construct(array $options = array())
    {
        if (!isset($options['url'])) {
            throw new Exception\InvalidArgumentException('Url key in options argument required');
        }

        $this->url = $options['url'];
        
        $this->txt = $options['txt'];

        if (isset($options['vars'])) {
            $this->vars = is_array($options['vars']) ? $options['vars'] : array($options['vars']);
        }
    }

    /**
     * Rendering decorator
     * @param string $context
     * @return string
     */
    public function render($context)
    {
        $values = array();
        if (count($this->vars)) {
            $actualRow = $this->getCell()->getActualRow();
            foreach ($this->vars as $var) {
                $values[] = $actualRow[$var];
            }
        }
        $url = vsprintf($this->url, $values);
        //var_dump($url);
        //var_dump($context);
        return sprintf('<a href="%s"><b>%s</b></a>', $url, $this->txt);
    }

}