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
     * The various states a XMLHttpRequest can be in, either before during or after
     * the request was execute
     */
    define('AJAXAC_RS_UNINIT'     , 0);
    define('AJAXAC_RS_LOADING'    , 1);
    define('AJAXAC_RS_LOADED'     , 2);
    define('AJAXAC_RS_INTERACTIVE', 3);
    define('AJAXAC_RS_COMPLETE'   , 4);

    /**
     * Timer specific events
     */
    define('AJAXAC_EV_ONXMLHTTPSUCCESS', 'xmlhttpsuccess');
    define('AJAXAC_EV_ONXMLHTTPFAILURE', 'xmlhttpfailure');
    define('AJAXAC_EV_ONREADYSTATECHANGE', 'onreadystatechange');

    require_once('AjaxACWidget.class.php');

    /**
     * A class used to implement the XMLHttpRequest JavaScript object
     *
     * @todo    Add extra functionality/events to deal with various request states and response codes,
     *          Rather than always having to use the onreadystatechange event and manually checking the
     *          states / codes
     *
     * @access  package
     * @author  Quentin Zervaas
     */
    class AjaxACWidgetXMLHttpRequest extends AjaxACWidget
    {
        /**
         * The HTTP request methods allowed
         *
         * @access  private
         * @param   array   $validMethods
         */
        var $validMethods = array(AJAXAC_METH_GET, AJAXAC_METH_POST);


        /**
         * An array holding JavaScripts variables + strings that
         * will be used for generating the subrequest
         *
         * @access  private
         * @param   array   $requestParams
         *                  + var           param name / JavaScript variable name pairs
         *                  + string        param name / literal string pairs
         */
        var $requestParams = array('var' => array(), 'string' => array());


        /**
         * AjaxACWidgetXMLHttpRequest
         *
         * Constructor. Init's the widget and sets the HTTP request method
         *
         * @access  package
         * @param   AjaxACApplication   &$application   A reference to the application this widget belongs to
         * @param   string      $name       The internal name of the widget, used within the application
         * @param   string      $method     The HTTP request method
         */
        function AjaxACWidgetXMLHttpRequest(&$application, $name, $method)
        {
            parent::AjaxACWidget($application, $name);
            $this->setMethod($method);
        }


        /**
         * setMethod
         *
         * Sets the HTTP request method. If the supplied method is invalid, sets it
         * to 'get'
         *
         * @access  package
         * @see     $validMethods
         * @param   string  $method     The HTTP request method - should be container in $validMethods
         */
        function setMethod($method)
        {
            $this->method = strtolower($method);
            if (!in_array($method, $this->validMethods))
                $this->method = $this->methods[0];
        }


        /**
         * setFilenameFromVar
         *
         * Sets the base request URL, from a JavaScript variable. Only
         * one of this method or setFilenameFromString should be called.
         * The variable shouldn't contain a query string if using the
         * methods below (addParamFromHookValue, addParamFromString)
         *
         * @access  package
         * @see     setFilenameFromString
         * @param   string  $varname    The JavaScript variable name
         */
        function setFilenameFromVar($varname)
        {
            $this->filenameVar = $varname;
        }

        /**
         * setFilenameFromString
         *
         * Sets the base request URL, from a literal string. Only
         * one of this method or setFilenameFromVar should be called
         *
         * @access  package
         * @param   string  $varname    The URL to fetch (omit query string)
         */
        function setFilenameFromString($str)
        {
            $this->filenameString = $str;
        }


        /**
         * addEventForResponseCode
         *
         * Allows a custom function for each different response code.
         * You can still use AJAXAC_EV_ONXMLHTTPSUCCESS with addEvent(),
         * which uses response code of 200, or you can use a custom
         * code with this. If you call this with 200 and you use the other,
         * this callback takes precedence. You can use AJAXAC_EV_ONXMLHTTPFAILURE
         * with addEvent() to cover any response code that has not yet been covered
         *
         * @access  package
         * @param   $callback   string  The callback function to be called for this event. The full function
         *                              name will be event_$callback. The callback returns a Javascript function
         */

        function addEventForResponseCode($code, $callback)
        {
            $this->addEvent($code, $callback);
        }



        /**
         * addParamFromHookValue
         *
         * Add a query string parameter using a JavaScript variable
         *
         * @access  package
         * @todo    Integrate the $element param in with the $hookname param
         * @param   string  $var        The query string variable name
         * @param   string  $hookname   The name of the JavaScript element
         * @param   string  $element    The sub-element of the JavaScript elements
         */
        function addParamFromHookValue($var, $hookname, $element = 'value')
        {
            $this->requestParams['var'][$var] = array('var' => $hookname, 'element' => trim($element));
        }


        /**
         * addParamFromHookValue
         *
         * Add a query string parameter using a literal string
         *
         * @access  package
         * @param   string  $var        The query string variable name
         * @param   string  $string     The literal string to include in query string
         */
        function addParamFromString($var, $string)
        {
            $this->requestParams['string'][$var] = $string;
        }


        function event_onreadystatechange(&$widget, $event)
        {
            $codes = array();
            if ($this->eventExists(AJAXAC_EV_ONXMLHTTPSUCCESS))
                $codes[200] = $this->getEventFunctionName(AJAXAC_EV_ONXMLHTTPSUCCESS);
            if ($this->eventExists(AJAXAC_EV_ONXMLHTTPFAILURE))
                $codes['default'] = $this->getEventFunctionName(AJAXAC_EV_ONXMLHTTPFAILURE);

            foreach ($this->_events as $event => $callback) {
                if (preg_match('/^\d+$/', $event)) { // is a HTTP status code
                    $codes[$event] = $this->getEventFunctionName($event);
                }
            }

            if (count($codes) > 0) {
                $switchOptions = array();

                $str = "%s: if (%s) %s(); break;";

                foreach ($codes as $code => $callback)
                    $switchOptions[] = sprintf($str, $code == 'default' ? $code : 'case ' . $code, $callback, $callback);

                $callback = "
                                function()
                                {
                                    if (%1\$s.readyState == %2\$d) {
                                        switch (%1\$s.status) {
                                            %3\$s
                                        }
                                    }
                                }
                            ";

                $callback = sprintf($callback,
                                    $this->getHookName(),
                                    AJAXAC_RS_COMPLETE,
                                    join("\n", $switchOptions));

                return $callback;
            }
            return null;
        }


        /**
         * getJsCode
         *
         * Generate the JavaScript code required to make this widget function,
         * such as event code. Determines the event code by calling the callbacks
         * in the application based on the events set in this widget
         *
         * @todo    Not sure if code is escaped in the right places
         * @return  string  The generated JavaScript code
         */
        function getJsCode()
        {
            $hook = $this->getHookName();

            $code = array();

            $code[] = sprintf("%s = ajaxac_createXMLHttp();", $hook);

            $getParts = array();
            if (isset($this->filenameVar)) {
                $location = $this->filenameVar;
            }
            else if (isset($this->filenameString)) {
                $location = "'" . $this->application->escapeJs($this->filenameString) . "'";
            }
            else {
                return '';
            }

            foreach ($this->requestParams['var'] as $k => $v) {
                if (strlen($v['element']) > 0)
                    $getParts[] = sprintf("'%s=' + encodeURIComponent(%s.%s)", $k, $v['var'], $v['element']);
                else
                    $getParts[] = sprintf("'%s=' + encodeURIComponent(%s)", $k, $v['var']);
            }

            foreach ($this->requestParams['string'] as $k => $v) {
                $getParts[] = sprintf("'%s=' + encodeURIComponent('%s')", $k, $v);
            }

            if (count($getParts) > 0) {
                $actionParameter = $this->application->getConfigValue('url.action_parameter');
                $joiner = strlen($actionParameter) == 0 ? '?' : '&';
                $location .= sprintf(" + '%s' + %s", $joiner, join(" + '&' + ", $getParts));
            }

            $code[] = sprintf("%s.open('%s', %s);", $hook, $this->method, $location);

            $this->addEvent(AJAXAC_EV_ONREADYSTATECHANGE, 'onreadystatechange');
            $code[] = parent::getJsCode();
            $code[] = sprintf("%s.%s = %s;", $hook, AJAXAC_EV_ONREADYSTATECHANGE, $this->getEventFunctionName('onreadystatechange'));
            $code[] = sprintf("%s.send(null);", $hook);

            return join("\n\n", $code);
        }

        function getEventFunctionName($event)
        {
            return $this->getHookName() . '_' . $event;
        }
    }
?>