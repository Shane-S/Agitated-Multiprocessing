<?php
/*
 * Menu navbar, just an unordered list
 */
?>

<div id="nav">
<ul>
    {menudata}
    <li>
        <a class="{menuname}" href="{menulink}"><span id="brace-left-{menuname}"class="brace">{</span>{menuname}<span id="brace-right-{menuname}"class="brace">}</span></a>
    </li>
    {/menudata}
</ul>
</div>