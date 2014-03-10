=======ADMINISTRATIVE NEEDS=========================================================

*   Admin account
    Username: JParry
    Password: JParry_admin

*   User account
    Username: JimP
    Password: JimP_user

*   Database information
    []  /scripts/agtitated-multiprocessing.sql contains the script to build all 
        tables
    []  Other than running that script in an exisisting database, there shouldn't be
        any other configuration


=======CRITIC NEEDS==================================================================
This section was already covered in the previous readme/design documentation. We have
advanced our goals somewhat by populating the site with real content and redesigning
the site to some degree.


=======INSTRUCTOR NEEDS==============================================================
__{ What Works }__
*   Post maintenance has:
    []  Image uploading
    []  Rich text editor
    []  Date picker
    []  RBAC (restricted to admin user only)

*   User maintenance has:
    []  Add/edit/delete controls
    []  RBAC (also restricted to admin)

*   Pagination
    []  Display new/old posts

*   Field-level templating
    []  All methods are implemented
    []  Edit/add user and edit/add post pages incorporate this
    []  Login page incorporates this (with some spacing issues)

__{ What Doesn't Work }__
Unfortunately, we also have this section. Currently, the following is in progress:
*   Pagination
    []  No tagging functionality

*   Field-level templating is not implemented in:
    []  Blog page
    []  Login sidebar
    []  Tables throughout the site

__{ Going Forward }__
To accomplish our goals, we will do the following:
*   Fix the above issues

*   Continue to redesign the site
    []  Change the colour scheme
    []  Redesign the blog and posts pages