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

    require_once('AjaxACWidget.class.php');

    /**
     * Timer specific events
     */
    define('AJAXAC_EV_ONTIMEREXPIRE', 'ontimerexpire');

    /**
     * A class for creating and using JavaScript timers
     *
     * @access  package
     * @author  Quentin Zervaas
     */
    class AjaxACWidgetTimer extends AjaxACWidget
    {
        /**
         * AjaxACWidgetTimer
         *
         * Constructor. Inits the widget
         *
         * @access  public
         * @param   AjaxACApplication   &$application   A reference to the application this widget belongs to
         * @param   string      $name       The internal name of the widget, used within the application
         */
        function AjaxACWidgetTimer(&$application, $name, $startOnLoad = false)
        {
            parent::AjaxACWidget($application, $name);
            $this->startOnLoad = $startOnLoad;
        }


        /**
         * start
         *
         * Start the countdown timer
         *
         * @access  public
         */
        function start()
        {
            return sprintf('%s.start();', $this->getHookName());
        }


        /**
         * reset
         *
         * stop and/or reset the countdown timer
         *
         * @access  public
         */
        function reset()
        {
            return sprintf('%s.reset();', $this->getHookName());
        }


        /**
         * setTimeoutFromVar
         *
         * Sets the timer countdown value from a JavaScript variable
         *
         * @access  public
         * @param   string  $varname    The name of the JavaScript variable
         */
        function setTimeoutFromVar($varname)
        {
            $this->timeoutVar = $varname;
        }


        /**
         * setTimeoutFromInt
         *
         * Sets the timer countdown value from a literal integer
         *
         * @access  public
         * @param   int     $int    Timeout in milliseconds (1000 ms = 1 second)
         */
        function setTimeoutFromInt($int)
        {
            $this->timeoutInt = $int;
        }


        /**
         * getJsCode
         *
         * Generate the JavaScript code required to make this widget function,
         * such as event code. Determines the event code by calling the callbacks
         * in the application based on the events set in this widget
         *
         * @return  string  The generated JavaScript code
         */
        function getJsCode()
        {
            $code = array();

            $commandStr = sprintf("'%s.ontimerexpire()'", $this->getHookName());

            if (isset($this->timeoutVar))
                $timeoutStr = $this->timeoutVar;
            else if (isset($this->timeoutInt))
                $timeoutStr = $this->timeoutInt;
            else
                return '';

            $code[] = sprintf('%s = new ajaxac_countdowntimer(%s, %s);',
                              $this->getHookName(),
                              $commandStr,
                              $timeoutStr);

            $code[] = parent::getJsCode();

            if ($this->startOnLoad)
                $code[] = $this->start();

            return join("\n", $code);
        }
    }
?>