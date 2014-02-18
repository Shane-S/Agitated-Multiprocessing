<?php
if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * view/template.php
 *
 * Pass in $pagetitle (which will in turn be passed along)
 * and $pagebody, the name of the content view.
 *
 * ------------------------------------------------------------------------
 */
?>

<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>{title}</title>
        <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    </head>
    <body>
        <div id="header">
            <div>
                <a href="/" class="logo">PugSureWoi</a>
                <ul>
                    {menubar}
                </ul>
            </div>
        </div>
        <div id="body">
            {content}
        </div>
        <div id="footer">
            <div class="logo">
                <a href="/"><img src="/assets/images/logo.jpg" alt="Logo"></a>
            </div>
            {menubar}
            <p>
                &copy; Copyright &copy; 2023. Company name all rights reserved
            </p>
            <div id="connect">
                <a href="http://freewebsitetemplates.com/go/facebook/" target="_blank" id="facebook">Facebook</a>
                <a href="http://freewebsitetemplates.com/go/twitter/" target="_blank" id="twitter">Twitter</a>
                <a href="http://freewebsitetemplates.com/go/googleplus/" target="_blank" id="googleplus">Google&#43;</a>
            </div>
        </div>
    </body>
</html>