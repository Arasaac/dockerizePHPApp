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
     * A class to hold widgets Mainly for providing an
     * interface to reference widgets and to fetch their JavaScript code
     *
     * @access  package
     * @author  Quentin Zervaas
     */
    class AjaxACWidget
    {
        /**
         * An array holding events attached to this widget, and callbacks for each event
         *
         * @access  private
         * @param   array   $_events    An array of event/callback pairs. The event is the key
         *                              as each event can only be applied once. Callback is the value
         */
        var $_events = array();


        /**
         * AjaxACWidget
         *
         * Constructor. Connects widget to application and sets widget properties.
         *
         * @access  package
         * @param   AjaxACApplication   &$application   A reference to the application this widget belongs to
         * @param   string      $name       The internal name of the widget, used within the application
         */
        function AjaxACWidget(&$application, $name)
        {
            $this->application = &$application;
            $this->_name = $name;
        }


        /**
         * getName
         *
         * Returns the internal application name for this widget
         *
         * @package
         * @return  string  The internal application name for this widget
         */
        function getName()
        {
            return $this->_name;
        }


        /**
         * addEvent
         *
         * Adds an event to the widget, as well as a callback name for the PHP function
         * to be called when the event occurs
         *
         * @access  package
         * @param   $event      string  The JavaScript event. A list is defined in AjaxACApplication
         * @param   $callback   string  The callback function to be called for this event. The full function
         *                              name will be event_$callback. The callback returns a Javascript function
         */
        function addEvent($event, $callback)
        {
            $this->_events[$event] = $callback;
        }


        /**
         * eventExists
         *
         * Checks whether or not a particular event has been added to a widget
         *
         * @access  package
         * @param   $event      string  The JavaScript event to check for
         * @return  bool                True if the event has been added, false if not
         */
        function eventExists($event)
        {
            return array_key_exists($event, $this->_events);
        }


        /**
         * getHookName
         *
         * Returns the javascript element name that references this widget. Note
         * that at this stage, the widget name is also used for the hook name,
         * so it must be JavaScript safe or there will be errors!
         *
         * @access  package
         * @todo    Generate a JavaScript-safe unique hookname (short as possible)
         * @return  string  The hook name
         */
        function getHookName()
        {
            return '__' . $this->getName();
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
            $ret = array();
            foreach ($this->_events as $event => $callback) {
                unset($code);
                $callback = 'event_' . $callback;
                if (method_exists($this->application, $callback))
                    $code = trim($this->application->$callback($this, $event));
                else if (method_exists($this, $callback))
                    $code = trim($this->$callback($this, $event));

                if (isset($code) && strlen($code) > 0) {
                    $ret[] = sprintf("%s = %s", $this->getEventFunctionName($event),
                                                $code);

                    // this is a hack to allow an onload event to take place
                    // for a created event (unless there's a builtin way for this?
                    if ($event == AJAXAC_EV_ONLOAD) {
                        $ret[] = sprintf("%s.%s();", $this->getHookName(), $event);
                    }
                }
            }

            return join("\n\n", $ret);
        }

        function getEventFunctionName($event)
        {
            return $this->getHookName() . '.' . $event;
        }
    }
?>