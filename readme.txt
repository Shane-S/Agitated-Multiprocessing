The server works correctly. The client is written, but does not properly post due to database errors.
For the server:
*   We adapted the capo controller from the example to populate our responses
    for info, posts, post(id) and latest RPC methods
*   We made a new database table, metadata, to hold the site name, syndication
    code, and plug for our site
    []  We can also use this later for other site metadata (keywords, for example)
*   We use the $_SERVER superglobal to get the URL
    for the site, which should make it independent of hosting environments
*   We've added a new page restricted to admins, sitemtce, that allows the admin
    to change the syndication code, the site name, and the site plug

For the client:
*   When a new post is added, we call the "syndicate_post" method to send it to
    the server
*   When the site information is changed, we call the "update_remote_info" method
    to send it to the server

For the next labs:
*   We are still redesigning the site. There are some bugs to be fixed still, and
    Kube reworked their framework, so we plan to integrate their changes.

NOTE: The site currently has a login bug. It is still possible to log in, but the
      browser is not properly redirected. Simply enter the URL for the homepage
      manually after submitting the login information.
      
      