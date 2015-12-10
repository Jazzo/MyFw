<?php
/**
 * Description of MyFw_SimplePager
 * Is a simple Pager for pagination
 * @author gullo
 */
class MyFw_SimplePager {
    
    /**
     * URL base to use
     * @var string
     */
    private $_url = "";
    
    /**
     * Page number
     * @var int
     */
    private $_page = 0;
    
    /**
     * How many results show for page
     * @var int
     */
    private $_view = 10;
    
    /**
     * Num Results shown
     * @var type 
     */
    private $_numResults = 0;
    
    /**
     * Set Page number INDEX (it starts from 0)
     * @param int $page
     */
    public function setPage($page)
    {
        $this->_page = (int)$page;
    }
    
    /**
     * Set number records to show
     * @param int $page
     */
    public function setView($view)
    {
        $this->_view = (int)$view;
    }

    /**
     * Set number resulted from the query
     * @param int $page
     */
    public function setNumResults($num)
    {
        $this->_numResults = (int)$num;
    }
    
    /**
     * Set URL base
     * @param string $url
     */
    public function setURL($url) 
    {
        $this->_url = $url;
    }
    
    /**
     * Return TRUE if has a Next page
     * @return boolean
     */
    public function hasNext()
    {
        return ($this->_numResults >= $this->_view) ? true : false;
    }
    
    /**
     * Return TRUE if has a Prev page
     * @return boolean
     */
    public function hasPrev()
    {
        return ($this->_page > 0) ? true : false;
    }
    
    /**
     * Return the URL for the Next page
     * @return string
     */
    public function getURL_Next()
    {
        return "/dashboard/index/page/" . ($this->_page + 1);
    }
    
    /**
     * Return the URL for the Prev page
     * @return string
     */
    public function getURL_Prev()
    {
        return "/dashboard/index/page/" . (($this->_page > 0) ? ($this->_page - 1) : 0);
    }
    
    /**
     * Return the Start number for the SQL LIMIT
     * @return int
     */
    public function getSQLStartNumber()
    {
        return ($this->_page * $this->_view);
    }
    
    /**
     * Return the limit number for the SQL LIMIT
     * @return int
     */
    public function getSQLLimitNumber()
    {
        return $this->_view;
    }
    
    /**
     * Return the Page Number to show
     * @return int
     */
    public function getPageNumber()
    {
        return $this->_page + 1;
    }
    
}