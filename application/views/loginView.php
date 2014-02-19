<?php
/**
 *  This is a view fragment, to hold a login form.
 * It is meant to be at the top of the sudebar in our layout.
 */
?>
<div class="well">
    <form method="post" action="/login/">
        <label for="id">User</label>
        <input type="text" name="username" id="username"/>
        <label for="password">Password</label>
        <input type="password" name="password" id="password"/>
        <input type="submit" Value ="Login"/>
    </form>
</div>
