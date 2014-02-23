<form class="forms forms-columnar"action="/usermtce/submit/{username}" method="post">
    <p>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="{username}" />
    </p>
    <p>
        <label for="password">Password</label>
        <input type="text" name="password" id="password" value="{password}" />
    </p>
    <p>
        <label for="firstname">First Name</label>
        <input type="text" name="firstname" id="firstname" value="{firstname}" />
    </p>
    <p>
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" id="lastname" value="{lastname}" />
    </p>
    <p>
        <label for="role">Role</label>
        <select name="role">
            {roles}
            <option value="{role}">{role}</option>
            {/roles}
        </select>
    </p>
    <p>
        <label for="email">Email Address</label>
        <input type="text" name="email" id="email" value="{email}" />
    </p>
    <br/><br/>
    <button type="submit">Submit</button>     
    <a href="/usermtce"><input type="button" value="Cancel"></input></a>
</form>
