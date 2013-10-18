<?php

class MyFw_Mail
    extends Zend_Mail
{
    /**
     * the zend Config object
     * @var zend_config
     */
    private $_config;

    /**
     *
     * @var Zend_View
     */
    static $_defaultView;
    /**
     * current instance of our Zend_View
     * @var Zend_View
     */
    protected $_view;

    /**
     * set up the mail object
     */
    public function  __construct($charset = "UTF-8")
    {
        parent::__construct($charset);

        // set Transport
		$this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/resources/Config/email.ini', APPLICATION_ENV);
        if ($this->_config->use_smtp_mail == 1) {
			Zend_Mail::setDefaultTransport( new Zend_Mail_Transport_Smtp($this->_config->smtp_host, $this->_config->smtp_cfg->toArray()) );
        }
		
		// Set Default From
        $this->SetFrom($this->_config->default_email, $this->_config->default_name);

        // set Zend_View
        $this->_view = self::getDefaultView();
    }

    protected static function getDefaultView()
    {
        if(self::$_defaultView === null) {
            self::$_defaultView = new MyFw_View();
            $config = Zend_Registry::get('appConfig');
            self::$_defaultView->addPath('template', $config->template->path_email);
        }
        return self::$_defaultView;
    }
    
    // set params in View instance
    public function setViewParam($property, $value)
    {
        $this->_view->assign($property, $value);
        return $this;
    }

    public function sendHtmlTemplate($template, $encoding = Zend_Mime::ENCODING_QUOTEDPRINTABLE)
    {
        $html = $this->_view->fetch($template);
        // ADD Footer if EXISTS
        $this->_view->assign('url_environment', Zend_Registry::get('appConfig')->url_environment);
        $html .= $this->_view->fetch("footer.tpl.php");
        // Set BODY Email
        $this->setBodyHtml($html);
        $this->setBodyText(strip_tags($html));
        try {
            if(APPLICATION_ENV == "production") {
                return $this->send();
            } else {
                // Log Email sent
                $my_log = "<br /><br />--------------- --------------- ---------------<br />" 
                        . "Email Inviata alle ". date("H:i:s") . "<br />"
                        . "<b>FROM</b>: ".$this->getFrom()."<br />"
                        . "<b>TO/CC/CCN</b>: ". implode(", ", $this->getRecipients()). "<br />"
                        . "<b>OGGETTO</b>: " . $this->getSubject() . "<br />---------------<br />"
                        . $this->getBodyHtml(true) . "<br />";
                $log = fopen( APPLICATION_PATH . '/tmp/LOG_EMAIL_SENT_' . date("dmY") . '.html','a');
                fwrite($log,$my_log);
                fclose($log);
                return true;
            }
        } catch (Exception $exc) {
            return false;
           /*
            * TODO: Catch Error and do something....
            echo "<pre>";
            echo $exc->getMessage();
            echo "</pre>";die;
            */
        }
    }

    
    
    
}