<?php
    /**
     * Copyright 2005 Zervaas Enterprises (www.zervaas.com.au)
     *
     * Licensed under the Apache License, Version 2.0 (the "License");
     * you may not use this file except in compliance with the License.
     * You may obtain a copy of the License at
     *
     *     http://www.apache.org/licenses/LICENSE-2.0
     *
     * Unless required by applicable law or agreed to in writing, software
     * distributed under the License is distributed on an "AS IS" BASIS,
     * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     * See the License for the specific language governing permissions and
     * limitations under the License.
     *
     * @package AjaxAC
     */

    /**
     * The various JavaScript events that can occur
     */
    define('AJAXAC_EV_ONFOCUS',            'onfocus');
    define('AJAXAC_EV_ONBLUR',             'onblur');
    define('AJAXAC_EV_ONMOUSEOVER',        'onmouseover');
    define('AJAXAC_EV_ONMOUSEOUT',         'onmouseout');
    define('AJAXAC_EV_ONMOUSEDOWN',        'onmousedown');
    define('AJAXAC_EV_ONMOUSEUP',          'onmouseup');
    define('AJAXAC_EV_ONSUBMIT',           'onsubmit');
    define('AJAXAC_EV_ONCLICK',            'onclick');
    define('AJAXAC_EV_ONLOAD',             'onload');
    define('AJAXAC_EV_ONCHANGE',           'onchange');
    define('AJAXAC_EV_ONKEYPRESS',         'onkeypress');
    define('AJAXAC_EV_ONKEYDOWN',          'onkeydown');
    define('AJAXAC_EV_ONKEYUP',            'onkeyup');

    /**
     * The HTTP subrequest types that can occur
     */
    define('AJAXAC_METH_GET',  'get');
    define('AJAXAC_METH_POST', 'post');

    /**
     * The file containing the core AjaxAC code (non-application specific code)
     */
    define('AJAXAC_CORE_JS_LIB', 'core.js');

    /**
     * The different levels of debugging
     */
    define('AJAXAC_DEBUG_NONE', 0);
    define('AJAXAC_DEBUG_CORE_ERROR', 1 << 0);

    define('AJAXAC_DEBUG-MAX', 1 << 16);
    define('AJAXAC_DEBUG_ERROR_ALL', AJAXAC_DEBUG_CORE_ERROR);
    define('AJAXAC_DEBUG_ALL', AJAXAC_DEBUG_MAX << 1 - 1);

    /**
     * The base class for all AjaxAC applications. Contains a wide range of functionality
     * for handling requests, subrequest, attaching actions/events/widgets/etc.. as well
     * as generating subrequest URL's and piecing together application JavaScript code.
     * This class should never been instantiated directly, as it won't do anything. Instead,
     * specific applications should extend this class, creating widgets + their events, as
     * well as actions + handlers for sub-requests
     *
     * @author  Quentin Zervaas
     * @access  Public
     */
    class AjaxACApplication
    {
        /**
         * An array holding all the widgets for our application
         *
         * @access  protected
         */
        var $_widgets = array();


        /**
         * An array holding paths to any additional JavaScript files
         * that need to be loaded in. They will be included directly
         * with the generated JavaScript
         *
         * @access  private
         */
        var $_jslibs = array();


        /**
         * The default character set to use for returned subrequest
         * data. Used only if not specified in the application config
         */
        var $_defaultCharset = 'UTF-8';


        /**
         * AjaxACApplication
         *
         * Constructor. Sets up the base actions, as well as installing
         * the application configuration
         *
         * @access  public
         * @param   array   $config     The application configuration, containing key/name pairs
         */
        function AjaxACApplication($config = array())
        {
            $this->registerActions('jscore', 'jsapp');
            // 'jscore' is the subrequest action for outputting AjaxAC core JavaScript
            // 'jsapp' is the subrequest action for outputting application specific JavaScript

            if (!is_array($config))
                $config = array($config);

            $this->_config = $config;

            // try and set the charset value if it hasn't been specified in $config
            $this->setConfigValue('charset', $this->_defaultCharset, false);

            // parameter to set the script name. If this is empty then the current
            // script name will be auto-detected
            $this->setConfigValue('url.script_name', '', false);

            // parameter to store sub-request action in. If empty it is specified like
            // index.php/someaction, other it is like index.php?action=someaction
            $this->setConfigValue('url.action_parameter', '', false);

            // parameter to determine whether or not to send the content-length header
            // which may break multi-byte encodings
            // @todo Find a way to send correct content length with multi-byte encodings
            $this->setConfigValue('js.send_content_length', true, false);


            // various debugging parameters
            $this->setConfigValue('debug.level', AJAXAC_DEBUG_NONE, false);
            $this->setConfigValue('debug.log_file', 'ajaxac.log', false);

            $this->debug(AJAXAC_DEBUG_CORE_ERROR, 'test');
        }


        /**
         * createWidget
         *
         * Create a new widget with the specified name
         *
         * @access  protected
         * @param   string  $name       The internal application name for our widget
         * @param   bool    $listener   True if the widget is a listener, false if not
         * @param   bool    $talker     True if the widget is a talker, false if not
         * @return  &AjaxAcWidget       A reference to the newly created widget
         */
        function &createWidget($name, $listener = false, $talker = false)
        {
            require_once('Widgets/AjaxACWidget.class.php');
            return new AjaxACWidget($this, $name, $listener, $talker);
        }


        /**
         * handleAction
         *
         * Handle a subrequest. This determines if the request action exists, and if
         * so, then performs if, using the passed on params and request data
         *
         * @access  package
         * @param   string  $action         The action name. The callback will be action_$action
         * @param   array   $params         A 0-indexed array containing each request path element after the action.
         *                                  For example, /path/to/ajaxac/actionname/param1/param2
         * @param   array   $requestData    The '$_GET' data from the request
         */
        function handleAction($action = null, $params = array(), $requestData = array())
        {
            $this->_params = $params;
            $this->_requestData = $requestData;
            $callback = 'action_' . $action;
            if (method_exists($this, $callback)) {
                $this->$callback();
            }
        }


        /**
         * loadJsCore
         *
         * Loads the AjaxAC core JavaScript code, either by displaying HTML code
         * to fetch it, or displaying the actual code. If displaying the actual code,
         * then optionally the HTTP headers can also be sent with the request. The script
         * will exit on completion of sending the code with HTTP headers.
         *
         * @access  public
         * @param   bool    $externalRef    True if only returning HTML code to call JavaScript
         * @param   bool    $sendHeaders    If $externalRef false, then set this true to include HTTP headers
         * @return  string                  If $externalRef true, then the HTML code will be returned
         */
        function loadJsCore($externalRef = false, $sendHeaders = false)
        {
            if ($externalRef) {
                $html = sprintf('<script type="text/javascript" src="%s"></script>',
                                htmlSpecialChars($this->getApplicationUrl('jscore')));
                return $html;
            }
            else {
                $jsLib = dirname(__FILE__) . '/' . AJAXAC_CORE_JS_LIB;
                if (!is_readable($jsLib)) {
                    if ($sendHeaders)
                        header('HTTP/1.0 404 Not Found');
                    exit;
                }
                $js = file_get_contents($jsLib);

                if ($sendHeaders) {
                    /**
                     * @todo Add etag/last-modified stuff to enable browser caching
                     * @todo Make content-length optional
                     */
                    header('Content-type: ' . $this->getContentType('text/javascript'));

                    if ($this->getConfigValue('js.send_content_length'))
                        header('Content-length: ' . strlen($js));
                }
                echo $js;
                if ($sendHeaders)
                    exit;
            }
        }


        /**
         * loadJsApp
         *
         * Loads the application JavaScript code, either by displaying HTML code
         * to fetch it, or displaying the actual code. If displaying the actual code,
         * then optionally the HTTP headers can also be sent with the request. The script
         * will exit on completion of sending the code with HTTP headers.
         *
         * @access  public
         * @param   bool    $externalRef    True if only returning HTML code to call JavaScript
         * @param   bool    $sendHeaders    If $externalRef false, then set this true to include HTTP headers
         * @return  string                  If $externalRef true, then the HTML code will be returned
         */
        function loadJsApp($externalRef = false, $sendHeaders = false)
        {
            if ($externalRef) {
                $html = sprintf('<script type="text/javascript" src="%s"></script>',
                                htmlSpecialChars($this->getApplicationUrl('jsapp')));
                return $html;
            }
            else {
                $js = $this->generateJsApp();
                if ($sendHeaders) {
                    /**
                     * @todo Add etag/last-modified stuff to enable browser caching
                     * @todo reuse this code with core stuff above
                     */
                    header('Content-type: ' . $this->getContentType('text/javascript'));
                    if ($this->getConfigValue('js.send_content_length'))
                        header('Content-length: ' . strlen($js));
                }

                echo $js;

                if ($sendHeaders)
                    exit;
            }
        }


        /**
         * getApplicationUrl
         *
         * Generates the application URL, for the specified action. This is used
         * to generate the request file for XMLHttp sub-requests
         *
         * @access  package
         * @todo    Add extra options for more path/request params
         * @param   string  $action     The action to generate the URL for. Must be a valid action
         * @return  string              The generated application URL
         */
        function getApplicationUrl($action = '')
        {
            if (!isset($this->_web_path)) {
                $this->_web_path = $this->getConfigValue('url.script_name');
                if (strlen($this->_web_path) == 0)
                    $this->_web_path = $_SERVER['SCRIPT_NAME'];
            }

            $ret = $this->_web_path;

            if (strlen($action) > 0 && $this->actionExists($action)) {
                $actionParameter = $this->getConfigValue('url.action_parameter');
                if (strlen($actionParameter) == 0)
                    $ret = $this->_web_path . '/' . $action;
                else
                    $ret = $this->_web_path . '?' . $actionParameter . '=' . $action;
            }

            return $ret;
        }


        /**
         * handleRequest
         *
         * Fetches parameters + options from the current request (be it the main
         * request or a sub-request), and hands it to the application for handling
         *
         * @todo    Allow for extra parameters when action store in GET variable
         * @access  public
         */
        function handleRequest()
        {
            $actionParameter = $this->getConfigValue('url.action_parameter');
            if (strlen($actionParameter) == 0) {
                $path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
                $params = array_filter(explode('/', $path));

                $action = count($params) > 0 ? array_shift($params) : '';
            }
            else {
                $action = isset($_GET[$actionParameter]) ? $_GET[$actionParameter] : '';
                $params = array();
            }

            $this->handleAction($action, $params, $_GET);
        }


        /**
         * addJsLib
         *
         * Add an external JavaScript library to the application code
         *
         * @access  protected
         * @param   $file       An absolute or relative file-system path to the code
         */
        function addJsLib($file)
        {
            $this->_jslibs[] = $file;
        }


        /**
         * generateJsApp
         *
         * Generates the application JavaScript code, combining the additional
         * libs with the generated code for widgets
         *
         * @access  private
         * @return  string      The generate JavaScript code
         */
        function generateJsApp()
        {
            $js = array();

            foreach ($this->_jslibs as $file) {
                if (is_readable($file) && is_file($file))
                    $js[] = file_get_contents($file);
            }

            $keys = array_keys($this->_widgets);

            $numWidgets = count($keys);
            for ($i = 0; $i < $numWidgets; $i++) {
                $key = $keys[$i];
                $obj = &$this->_widgets[$key];

                // now generate the js code for each widget
                $js[] = $obj->getJsCode();
            }

            return join("\n", $js);
        }

        /**
         * getHookName
         *
         * Determines the hookname for the passed internal application ID.
         * This is used to determine a hookname for an element we know the
         * name of but don't have direct access to
         *
         * @access  protected
         * @param   string  $name   The internal application ID of the widget
         * @return  string          The hook name of the element, or null if not found
         */
        function getHookName($name)
        {
            if (array_key_exists($name, $this->_widgets))
                return $this->_widgets[$name]->getHookName();
            return null;
        }


        /**
         * registerActions
         *
         * @access protected
         *
         * Register one or more actions, to be handled using a callback
         * named something like action_actionName(). Takes an arbitrary
         * number of parameters.
         */
        function registerActions()
        {
            foreach (func_get_args() as $action) {
                $action = trim($action);
                if (strlen($action) > 0)
                    $this->_actions[] = $action;
            }
        }


        /**
         * actionExists
         *
         * Returns whether or not an action exists
         *
         * @access  protected
         * @return  bool        True if the action exists, false if not
         */
        function actionExists($action)
        {
            return in_array($action, $this->_actions);
        }


        /**
         * attachWidget
         *
         * Attach a single widget. That is, connect a HTML element to an internal
         * widget so events and actions can be applied to that HTML element
         *
         * @access  public
         * @param   string  $internalId     The internal widget name being connected to
         * @param   string  $jsId           The ID of the connecting HTML element
         * @return  string                  The necessary JavaScript code to attach the widget
         */
        function attachWidget($internalId, $jsId)
        {
            $ret = sprintf("<script type=\"text/javascript\">ajaxac_attachWidget('%s', '%s');</script>",
                           $this->getHookName($internalId),
                           $jsId);
            return $ret;
        }


        /**
         * attachWidgets
         *
         * Attach multiple widgets. That is, connect HTML elements to internal
         * widgets so events and actions can be applied to them.
         *
         * @access  public
         * @param   array   $arr    An array of widgets. Key is widget name, value is HTML ID
         * @return  string          The necessary JavaScript code to attach the widgets
         */
        function attachWidgets($arr)
        {
            if (!is_array($arr))
                return '';

            $lines[] = '<script type="text/javascript">';
            foreach ($arr as $internalId => $jsId) {
                $lines[] = sprintf("ajaxac_attachWidget('%s', '%s');",
                                   $this->getHookName($internalId),
                                   $jsId);
            }
            $lines[] = '</script>';

            return join("\n", $lines);
        }


        /**
         * addWidget
         *
         * Adds a widget to the application
         *
         * @access  protected
         * @param   AjaxACWidget    &$widget    The widget to add
         */
        function addWidget(&$widget)
        {
            $this->_widgets[$widget->getName()] = &$widget;
        }


        /**
         * XmlHttpRequest
         *
         * Creates a XmlHttpRequest widget, with specified name
         * and action. Further parameters and event handlers
         * are added later on
         *
         * @access  protected
         * @param   string  $name   The internal name for the widget. Will not conflict with other widgets
         * @param   string  $method The HTTP request method, such as get or post
         * @return  AjaxACWidgetXMLHttpRequest      The created request object
         */
        function XmlHttpRequest($name, $method)
        {
            require_once('Widgets/AjaxACWidgetXMLHttpRequest.class.php');
            return new AjaxACWidgetXMLHttpRequest($this, $name, $method);
        }

        /**
         * getParam
         *
         * Retrieve a parameter from the user request. You can choose to return
         * some default value if the parameter is null or not set
         *
         * @access  protected
         * @param   string  $key        The name of the param to return
         * @param   mixed   $default    A default value to return if the key doesn't exist or is null
         * @return  mixed               The fetched or default value
         */
        function getParam($key, $default = null)
        {
            if (!array_key_exists($key, $this->_params) || is_null($this->_params[$key]))
                return $default;
            return $this->_params[$key];
        }

        /**
         * getRequestValue
         *
         * Retrieve a parameter from the user request. You can choose to return
         * some default value if the parameter is null or not set
         *
         * @access  protected
         * @param   string  $key        The name of the request value to return
         * @param   mixed   $default    A default value to return if the key doesn't exist or is null
         * @return  mixed               The fetched or default value
         */
        function getRequestValue($key, $default = null)
        {
            if (!array_key_exists($key, $this->_requestData) || is_null($this->_requestData[$key]))
                return $default;
            return $this->_requestData[$key];
        }

        /**
         * setConfigValue
         *
         * Add a parameter to the config. You can optionally choose to set it only
         * if it doesn't already exist using the force parameter
         *
         * @access  protected
         * @param   string  $key        The name of the config value to set
         * @param   mixed   $val        The value to set
         * @param   bool    $force      True to set the value no matter, false to set if doesn't exist
         * @return  bool                True if value set, false if not (can only return false if $force is false or $key is empty)
         */
        function setConfigValue($key, $val, $force = true)
        {
            if (strlen($key) > 0 && ($force || !array_key_exists($key, $this->_config))) {
                $this->_config[$key] = $val;
                return true;
            }
            return false;
        }

        /**
         * getConfigValue
         *
         * Retrieve a parameter from the application config. You can choose to return
         * some default value if the parameter is null or not set
         *
         * @access  protected
         * @param   string  $key        The name of the config value to return
         * @param   mixed   $default    A default value to return if the key doesn't exist or is null
         * @return  mixed               The fetched or default value
         */
        function getConfigValue($key, $default = null)
        {
            if (!isset($this->_config) || !array_key_exists($key, $this->_config) || is_null($this->_config[$key]))
                return $default;
            return $this->_config[$key];
        }


        /**
         * sendResponseData
         *
         * Send some data back as a response to a HTTP subrequest. Can be in various
         * data formats, each of which treat the data different and send headers
         * accordingly. The script exits after this method is called.
         *
         * @todo    Cache control functionality
         * @todo    Move actual data output / headers into separate section so can be used elsewhere
         * @param   string  $type       The type of data being sent
         * @param   mixed   $data       The data to return
         */
        function sendResponseData($type, $data)
        {
            $type = strtolower($type);

            // check if there's a handler for this data type. if not
            // just assume it's plain text and send the data as is with a text/plain
            // mime type.
            $callback = 'response_' . $type;

            if (method_exists($this, $callback)) {
                $response = $this->$callback($data);

                // the returned data should be an array with a 'mime' elements
                // and a 'data' element. if not an array, then the returned data
                // is output. if no mime type found then text/plain is used

                if (is_array($response)) {
                    if (isset($response['mime']))
                        $mime = $response['mime'];

                    if (isset($response['data']))
                        $data = $response['data'];
                    else
                        $data = '';
                }
                else {
                    $mime = 'text/plain';
                    $data = $response;
                }
            }
            else
                $mime = 'text/plain';

            header('Content-type: ' . $this->getContentType($mime));
            header('Content-length: ' . strlen($data));

            echo $data;
            exit;
        }


        /**
         * response_xml
         *
         * Outputs XML data. Assumes it is receiving well-formed XML
         *
         * @param   mixed   $data       The data to return
         * @return  array               A reponse type array, with mime and data elements
         */
        function response_xml($data)
        {
            return array('mime' => 'text/xml',
                         'data' => $data);
        }


        /**
         * response_jsarray
         *
         * Handle the jsarray response type
         *
         * @param   mixed   $data       The data to return
         * @return  array               A reponse type array, with mime and data elements
         */
        function response_jsarray($data)
        {
            return array('mime' => 'text/javascript',
                         'data' => $this->_phpArrayToJs($data));
        }

        /**
         * _phpArrayToJs
         *
         * Helper function for jsarray response type
         */
        function _phpArrayToJs($arr)
        {
            $items = array();

            foreach ($arr as $k => $v) {
                if (is_array($v))
                    $items[] = $this->_phpArrayToJs($v);
                else if (is_int($v))
                    $items[] = $v;
                else
                    $items[] = "'" . $this->escapeJs($v) . "'";
            }

            return '[' . join(',', $items) . ']';
        }


        /**
         * escapeJs
         *
         * Make a string JavaScript-safe so errors are not generated. This code was
         * shamelessly borrowed from Smarty
         *
         * @access  protected
         * @param   string  $str    The string to escape
         * @return  string          The escaped string
         */
        function escapeJs($str)
        {
            // borrowed from smarty
            return strtr($str, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/'));
        }

        // core action handlers

        /**
         * action_jscore
         *
         * Handles the jscore action - returns the full core JavaScript code plus HTTP headers
         *
         * @access private
         */
        function action_jscore()
        {
            $this->loadJsCore(false, true);
        }

        /**
         * action_jsapp
         *
         * Handles the jsapp action - returns the full lib JavaScript code plus HTTP headers
         *
         * @access private
         */
        function action_jsapp()
        {
            $this->loadJsApp(false, true);
        }

        function getContentType($type)
        {
            $type = trim($type);
            if (preg_match('|^text/|i', $type)) {
                $charset = $this->getConfigValue('charset', $this->_defaultCharset);
                $type .= '; charset=' . $charset;
            }
            return $type;
        }

        function debug($level, $str)
        {
            if (($level & $this->getConfigValue('debug.level')) && !$this->getConfigValue('debug.abort')) {
                if (!isset($this->_debug_fp)) {
                    $this->_debug_fp = @fopen($this->getConfigValue('debug.log_file'), 'a+');
                    if (!$this->_debug_fp) {
                        $this->setConfigValue('debug.abort', true);
                        return;
                    }
                    fwrite($this->_debug_fp, "\n\n\n\n\n[" . date('Y-m-d H:i:s') . "] -- MARK --\n");
                }
                fwrite($this->_debug_fp, '[' . date('Y-m-d H:i:s') . '] ' . $str . "\n");
            }
        }
    }
?>