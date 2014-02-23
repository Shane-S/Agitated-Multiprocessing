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
        <link rel="stylesheet" type="text/css" href="/assets/css/kube.min.css" />
        <script type="text/javascript" src="kube.buttons.js"></script>
	<script type="text/javascript" src="/assets/js/jquery-1.7.min.js"></script>	
	<script type="text/javascript" src="/assets/js/kube.datepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/assets/css/kube.datepicker.css" /> 
        <link rel="stylesheet" type="text/css" href="/assets/css/master.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/kube.min.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    </head>
    <body>
        <div id="container">
            <div id="main">
                <div id="header">
                    {sidebar}
                    <div id="title-menu">
                        <a href="/" class="logo"></a>
                        <img id="left-brace" src="/assets/images/left-brace.png" alt="left-brace"/>
                        {menubar}
                        <img id="right-brace" src="/assets/images/right-brace.png" alt="right-brace"/>
                    </div>
                </div>
                <div id="body">
                    {content}
                </div>
            </div>
        </div>
        <div id="footer">
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