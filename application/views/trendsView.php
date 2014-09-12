<?php
if(!defined('APPPATH'))
    exit('No direct script access allowed');
?>
<div id="section">
    <div>
        <table class="panel" id="trends_XML">
            {trends_xml}
        </table>

        <h1> Sources </h1>
            <a href ="http://www.theesa.com/facts/pdfs/esa_ef_2008.pdf">1</a>
            <a href ="http://www.theesa.com/facts/pdfs/ESA_EF_2009.pdf">2</a>
            <a href ="http://www.theesa.com/facts/pdfs/esa_essential_facts_2010.pdf">3</a>
            <a href ="http://www.theesa.com/facts/pdfs/ESA_EF_2011.pdf">4</a>
            <a href ="http://www.theesa.com/facts/pdfs/esa_ef_2012.pdf">5</a>
            <a href ="http://www.theesa.com/facts/pdfs/esa_ef_2013.pdf">6</a>

        <h1> Schema Validation Results </h1>
        <p>{trends_results}</p>
        <h1>Views</h1>
        <ul>
            <li><a href="/trends/xsl_version">XSL-Rendered Table</a></li>
            <li><a href="/trends">PHP-Rendered Table</a></li>
        </ul>
    </div>
</div>