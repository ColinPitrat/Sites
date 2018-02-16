// ==UserScript==
// @name           User script template
// @namespace      http://mywebsite.com/myscripts
// @description    A template for creating new user scripts from
// @include        *
// ==/UserScript==

function do_modify_html_it(doc, element, match_re, replace_string) 
{    
    match_re = new RegExp(match_re);    
    if (element.innerHTML) 
    {
        element.innerHTML = element.innerHTML.replace(match_re, replace_string);    
    };
};

function do_platypus_script()
{
    do_modify_html_it(window.document,document.evaluate('/HTML[1]/BODY[1]/FORM[1]/TABLE[2]/TBODY[1]/TR[1]/TD[1]/TABLE[1]/TBODY[1]/TR[2]/TD[1]/TABLE[1]/TBODY[1]/TR[1]/TD[1]/IMG[1]', document, null, XPathResult.FIRST_ORDERED_NODE_TYPE,null).singleNodeValue,/setTimeout("sendValidationCommand()",1000);/g,'setTimeout("sendValidationCommand()",1);',null);
};

window.addEventListener("load", function() { do_platypus_script() }, false);
