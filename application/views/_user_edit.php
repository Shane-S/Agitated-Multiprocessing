<?php
if (isset($errors) && count($errors) > 0) {
    ?>
    <div class="alert alert-error">
        <p><strong></strong></p>
        <?php
        foreach ($errors as $booboo)
            echo '<p>' . $booboo . '</p>';
        ?>
    </div>
<?php }
?>

<div>
    <form action="/usermtce/submit/{username}" method="post">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="{username}" />
    <label for="password">Password</label>
    <input type="text" name="password" id="password" value="{password}" />
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="email" value="{firstname}" />
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="email" value="{lastname}" />
    <label for="role">Role</label>
    <input type="text" name="role" id="role" value="{role}" />
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email" value="{email}" />
    <br/><br/>
    <button type="submit">Submit</button>     
    <a href="/usermtce"><input type="button" value="Cancel"></input></a>
</form>
</div>
