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
        <script type="text/javascript" src="/assets/js/kube.buttons.js"></script>
	<script type="text/javascript" src="/assets/js/jquery-1.7.min.js"></script>	
	<script type="text/javascript" src="/assets/js/kube.datepicker.min.js"></script>
        <script type="text/javascript" src="/assets/js/navbar.js"></script>
        <script type="text/javascript" src="/assets/js/hoverIntent.js"></script>

	<link rel="stylesheet" type="text/css" href="/assets/css/kube.datepicker.css" /> 
        <link rel="stylesheet" type="text/css" href="/assets/css/master.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/kube.min.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
        {caboose_styles}
    </head>
    <body>
        <div id="container">
            <div id="main">
                <div id="header">
                    {sidebar}
                    <div id="gutter"></div>
                    <a href="/" class="logo"></a>
                    {menubar}
                </div>
                <div id="body">
                    {content}
                </div>
            </div>
        </div>
        <div id="footer">
            <p>
                &copy; Copyright &copy; 2023. Company name all rights reserved
            </p>
            <div id="connect">
                <a href="http://freewebsitetemplates.com/go/facebook/" target="_blank" id="facebook">Facebook</a>
                <a href="http://freewebsitetemplates.com/go/twitter/" target="_blank" id="twitter">Twitter</a>
                <a href="http://freewebsitetemplates.com/go/googleplus/" target="_blank" id="googleplus">Google&#43;</a>
            </div>
        </div>
        {caboose_scripts}
        {caboose_trailings}
    </body>
</html>