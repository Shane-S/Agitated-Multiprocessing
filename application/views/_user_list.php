<h1>Users</h1>
<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Created at</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    {users}
    <tr>
        <td>{username}</td>
        <td>{firstname}</td>
        <td>{lastname}</td>
        <td>{email}</td>
        <td>{created_at}</td>
        <td>{role}</td>
        <td><input type="button" value="Edit" onclick="window.location.href='/usermtce/edit/{username}'"/>
        <input type="button" value="Delete" onclick="window.location.href='/usermtce/delete/{username}'"/></td>
    {/users}
</table>
<input type="button" value="Add" onclick="window.location.href='/usermtce/add'"/>