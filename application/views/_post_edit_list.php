<table>
    <thead>
        <th>Title</th>
        <th>Author</th>
        <th>Created</th>
        <th>Last modified</th>
        <th>Actions</th>
    </thead>
    <tbody>
        {posts}
        <tr>
            <td>{title}</td>
            <td>{username}</td>
            <td>{created_at}</td>
            <td>{updated_at}</td>
            <td>
                <input type="button" value="Edit" onclick="window.location.href='/postmtce/edit/{postid}'"/>
                <input type="button" value="Delete" onclick="window.location.href='/postmtce/delete/{postid}'"/>
            </td>
        </tr>
        {/posts}
    </tbody>
</table>
<input type="button" value="Add" onclick="window.location.href='/postmtce/add'"/>
