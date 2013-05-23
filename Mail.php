<?php
include_once 'PHPMailer/class.phpmailer.php';
class MyFw_Mail
    extends PHPMailer
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
		$this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/resources/config/email.ini', APPLICATION_ENV);
        if ($this->_config->use_smtp_mail == 1)
		{
            $this->IsSMTP();
            $this->Host          = $this->_config->smtp_host;
            $this->Helo          = $this->_config->smtp_cfg->name;
            $this->SMTPAuth      = true;
            $this->Username      = $this->_config->smtp_cfg->username;
            $this->Password      = $this->_config->smtp_cfg->password;

            /**
            * Sets connection prefix.
            * Options are "", "ssl" or "tls"
            * @var string
            */
            $this->SMTPSecure    = 'ssl';
            $this->Port = 465;
            
//			Zend_Mail::setDefaultTransport( new Zend_Mail_Transport_Smtp($this->_config->smtp_host, $this->_config->smtp_cfg->toArray()) );
        }
		
		// Set Default From
        $this->SetFrom($this->_config->default_email, $this->_config->default_name, false );

        // set Zend_View
        $this->_view = self::getDefaultView();
    }

    protected static function getDefaultView()
    {
        if(self::$_defaultView === null)
        {
            $appConfig = Zend_Registry::get('appConfig');
            self::$_defaultView = new MyFw_View(array('template_path' => $appConfig->template->path_email));
        }
        return self::$_defaultView;
    }
    
    // set Subject (Translate it!)
    public function setSubject($subject)
    {
        $this->Subject = $subject;
        return $this;
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
        $this->Body = $html;
        $this->IsHTML(true);
        // $this->setBodyText(strip_tags($html));
        return $this->Send();
    }

    
    
    
}