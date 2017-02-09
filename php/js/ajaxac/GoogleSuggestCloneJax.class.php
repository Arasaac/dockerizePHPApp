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
     */

    require_once('admin/js/ajaxac/lib/AjaxACApplication.class.php');

    class GoogleSuggestCloneJax extends AjaxACApplication
    {
        /**
         * Database connection details
         */
        var $db_hostname = 'localhost';
        var $db_username = 'root';
        var $db_password = '';
        var $db_database = 'arablog';
        var $db_table    = 'arablog_blogs';

        /**
         * Time to wait after a keypress before fetching suggestions
         */
        var $keypress_timeout_ms = 350;

        /**
         * Maximum number of suggestions to return
         */
        var $suggestion_limit = 10;

        /**
         * Constructor. Creates the necessary action and then inits widgets
         */
        function GoogleSuggestCloneJax()
        {
            parent::AjaxACApplication();
            $this->registerActions('getsuggestions');
            $this->setup();
        }

        /**
         * Create necessary widgets and events
         */
        function setup()
        {
            // utility functions for the app
            $this->addJsLib('admin/js/ajaxac/googlesuggestclone.js');

            // the form input where users type their query
            $query = $this->createWidget('query');
            $query->addEvent(AJAXAC_EV_ONKEYDOWN, 'querykeydown');
            $this->addWidget($query);

            // the div where results will be displayed
            $results = $this->createWidget('results');
            $results->addEvent(AJAXAC_EV_ONLOAD, 'resultsload');
            $this->addWidget($results);

            // the countdown timer that is started/reset after a key is pressed
            require_once('admin/js/ajaxac/lib/Widgets/AjaxACWidgetTimer.class.php');
            $timer = new AjaxACWidgetTimer($this, 'gsctimer');
            $timer->addEvent(AJAXAC_EV_ONTIMEREXPIRE, 'timerexpire');
            $timer->setTimeoutFromInt($this->keypress_timeout_ms);
            $this->addWidget($timer);
        }

        /**
         * Handle the getsuggestion HTTP subrequest
         */
        function action_getsuggestions()
        {
            $suggestions = array();
            $this->getSuggestions($this->getRequestValue('q'), $suggestions);
            $this->sendResponseData('jsarray', $suggestions);
        }

        /**
         * Initialise results output by clearing and hiding it
         */
        function event_resultsload(&$widget, $event)
        {
            return "function() { gsc_emptyresults(this); }";
        }

        /**
         * Handle various keypresses that occur on query input
         */
        function event_querykeydown(&$widget, $event)
        {
            $callback = "
                            function(e)
                            {
                                key = ajaxac_getkeycode(e);
                                switch (key) {
                                    case 27: // escape
                                        gsc_hide(%1\$s);
                                        return false;
                                        break;
                                    case 38: // up arrow
                                        gsc_handleup(%1\$s, %2\$s);
                                        return false;
                                        break;
                                    case 40: // down arrow
                                        gsc_handledown(%1\$s, %2\$s);
                                        return false;
                                        break;
                                    default:
                                        %3\$s.start();
                                }
                                return true;
                            }
                        ";

            $callback = sprintf($callback,
                                $this->getHookName('results'),
                                $this->getHookName('query'),
                                $this->getHookName('gsctimer'));

            return $callback;
        }

        /**
         * Handle the time expiring (i.e. initiate the HTTP sub request
         */
        function event_timerexpire(&$widget, $event)
        {
            require_once('admin/js/ajaxac/lib/Widgets/AjaxACWidgetXMLHttpRequest.class.php');
            $xmlhttp = new AjaxACWidgetXMLHttpRequest($this, 'gscfetch', AJAXAC_METH_GET);
            $xmlhttp->setFilenameFromString($this->getApplicationUrl('getsuggestions'));
            $xmlhttp->addParamFromHookValue('q', '_q', '');
            $xmlhttp->addEvent(AJAXAC_EV_ONXMLHTTPSUCCESS, 'handlesuggestions');
            $this->addWidget($xmlhttp);

            $callback = "
                            function()
                            {
                                _q = gsc_getquery(%1\$s, %2\$s.value);
                                if (_q.length == 0)
                                    return false;
                                try {
                                    %3\$s
                                }
                                catch (e) { }


                                return false;
                            }
                        ";

            $callback = sprintf($callback,
                                $this->getHookName('results'),
                                $this->getHookName('query'),
                                $xmlhttp->getJsCode());

            return $callback;
        }

        /**
         * Receive the suggestions and load them into results box
         */
        function event_handlesuggestions(&$widget, $event)
        {
            $callback = "
                            function()
                            {
                                _data = ajaxac_receivejsarray(%1\$s.responseText);
                                gsc_emptyresults(%2\$s);
                                if (_data.length > 0) {
                                    for (i = 0; i < _data.length; i++) {
                                        gsc_addresult(%2\$s, %3\$s, _data[i][0], _data[i][1], i == 0);
                                    }
                                    gsc_show(%2\$s);
                                }
                            }
                        ";
            $callback = sprintf($callback,
                                $widget->getHookName(),
                                $this->getHookName('results'),
                                $this->getHookName('query'));
            return $callback;
        }

        /**
         * Get the suggestions from the database and write to array
         */
        function getSuggestions($prefix, &$arr)
        {
            $conn = @mysql_connect($this->db_hostname, $this->db_username, $this->db_password);
            if (!$conn)
                return;
            if (!@mysql_select_db($this->db_database, $conn)) {
                mysql_close($conn);
                return;
            }

            // firstly clean up the data
			$prefix = ltrim(preg_replace('/[^a-z0-9_. ]/', '', strtolower($prefix)));
            $prefix = preg_replace('/\s+/', ' ', $prefix);
            if (strlen($prefix) > 0) {
                $query = sprintf("select blog, id
                                    from %s
                                    where blog like '%s%%'
                                    limit %d",
                                 $this->db_table,
                                 mysql_real_escape_string($prefix),
                                 $this->suggestion_limit);
                $result = mysql_query($query);
                while ($row = mysql_fetch_row($result)) {

                    $row[1] = utf8_encode($row[1]);
					$row[0] = utf8_encode($row[0]);
					$arr[] = $row;
                }
            }
            mysql_close($conn);
        }
    }
?>