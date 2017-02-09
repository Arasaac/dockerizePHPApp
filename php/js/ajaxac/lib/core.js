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
 */

function ajaxac_createXMLHttp()
{
    var ret = null;
    try {
        ret = new ActiveXObject('Msxml2.XMLHTTP');
    }
    catch (e) {
        try {
            ret = new ActiveXObject('Microsoft.XMLHTTP');
        }
        catch (ee) {
            ret = null;
        }
    }
    if (!ret && typeof XMLHttpRequest != 'undefined')
        ret = new XMLHttpRequest();

    return ret;
}

function ajaxac_attachWidget(hook, id)
{
    if (hook.length > 0 && id.length > 0) {
        evalStr = hook + " = document.getElementById('" + id + "');";
        eval(evalStr);
    }
}

function ajaxac_receivejsarray(code)
{
    eval('var ret = ' + code);
    return ret;
}

function ajaxac_countdowntimer(cmd, ms)
{
    this.cmd = cmd;
    this.ms = ms;
    this.tp = 0;
}

ajaxac_countdowntimer.prototype.start = function()
{
    if (this.tp > 0)
        this.reset();
    this.tp = window.setTimeout(this.cmd, this.ms);
}

ajaxac_countdowntimer.prototype.reset = function()
{
    if (this.tp > 0)
        window.clearTimeout(this.tp);
    this.tp = 0;
}

function trim(str)
{
    return str.replace(/^(\s+)?(\S*)(\s+)?$/, '$2');
}

function ltrim(str)
{
    return str.replace(/^\s*/, '');
}

function rtrim(str)
{
    return str.replace(/\s*$/, '');
}

function delay(milliseconds)
{
    var then, now;
    then = new Date().getTime();
    now = then;
    while ((now - then) < milliseconds) {
        now = new Date().getTime();
    }
}

function ajaxac_getkeycode(e)
{
    if (document.layers)
        return e.which;
    else if (document.all)
        return event.keyCode;
    else if (document.getElementById)
        return e.keyCode;
    return 0;
}