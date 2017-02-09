
var gsc_basicmatch = /[a-z0-9]/i;

function gsc_getquery(elt, q)
{
    q = ltrim(q);
    q = q.replace('\s+', ' ');
    if (q.length == 0 || !gsc_basicmatch.test(q)) {
        gsc_emptyresults(elt);
        return '';
    }

    if (elt.currentQuery && (elt.currentQuery == q || elt.tempQuery == q))
        return '';

    elt.currentQuery = q;
    return q;
}

function gsc_hide(elt)
{
    if (elt) elt.style.display = 'none';
}

function gsc_ishidden(elt)
{
    return elt.style.display == 'none';
}

function gsc_show(elt)
{
    if (elt) elt.style.display = 'block';
}

function gsc_emptyresults(elt)
{
    if (!elt) return;

    elt.innerHTML = '';
    elt.numResults = 0;
    elt.selectedIndex = 0;
    elt.results = [];
    gsc_hide(elt);
}

function gsc_addresult(elt, qElt, q, c, sel)
{
    if (!elt) return;

    if (sel) elt.selectedIndex = elt.numResults;

    idx = elt.numResults;
    elt.results[elt.numResults++] = c;

    var _res = '';
    _res += '<div class="' + (sel ? 'srs' : 'sr') + '"'
         +  ' onmouseover="gsc_mouseover(\'' + elt.id + '\', \'' + qElt.id + '\', ' + idx + ')"'
         +  ' onmouseout="gsc_mouseout(\'' + elt.id + '\', ' + idx + ')"'
         +  ' onclick="gsc_mouseclick(\'' + elt.id + '\', \'' + qElt.id + '\', ' + idx + ')">';
    _res += '<span class="srt">' + q + '</span>';
    if (c.length > 0)
        _res += '<span class="src">ID: ' + c + '</span>';
    _res += '</div>';

    elt.innerHTML += _res;
}

function gsc_mouseover(id, qId, idx)
{
    elt = document.getElementById(id);
    elt.selectedIndex = idx;
    qElt = document.getElementById(qId);
    qElt.focus();

    gsc_highlightsel(elt);
}

function gsc_mouseout(id, idx)
{
    elt = document.getElementById(id);
    elt.selectedIndex = -1;

    gsc_highlightsel(elt);
}

function gsc_mouseclick(id, qId, idx)
{
    elt = document.getElementById(id);
    qElt = document.getElementById(qId);

    qElt.value = elt.results[idx];
    qElt.form.submit();
}

function gsc_handleup(elt, qElt)
{
    if (elt.numResults > 0 && gsc_ishidden(elt)) {
        gsc_show(elt);
        return;
    }

    if (elt.selectedIndex == 0)
        return;
    else if (elt.selectedIndex < 0)
        elt.selectedIndex = elt.numResults - 1;
    else
        elt.selectedIndex--;
    gsc_highlightsel(elt, qElt);
}

function gsc_handledown(elt, qElt)
{
    if (elt.numResults > 0 && gsc_ishidden(elt)) {
        gsc_show(elt);
        return;
    }

    if (elt.selectedIndex == elt.numResults - 1)
        return;
    else if (elt.selectedIndex < 0)
        elt.selectedIndex = 0;
    else
        elt.selectedIndex++;
    gsc_highlightsel(elt, qElt);
}

function gsc_highlightsel(elt, qElt)
{
    divs = elt.getElementsByTagName('div');

    for (i = 0; i < divs.length; i++) {
        if (i == elt.selectedIndex) {
            divs[i].className = 'srs';
            elt.tempQuery = elt.results[i];

            if (qElt) {
                qElt.value = elt.results[i];
                if (qElt.createTextRange) {
                    r = qElt.createTextRange();
                    r.moveStart('character', elt.currentQuery.length);
                    r.moveEnd('character', qElt.value.length);
                    r.select();
                }
            }
        }
        else
            divs[i].className = 'sr';
    }
}
