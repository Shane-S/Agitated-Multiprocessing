<?php
/**
 *  This is a view fragment, to hold a login form.
 * It is meant to be at the top of the sudebar in our layout.
 */
?>
<div class="well">
    Hi, {userName} ({userRole})<br/>
    {secret_menu}
    <a href="/logout">Logout</a><br/>
</div>
