Notes
-   Input validation didn't make it in. Submitting something invalid will probably break things, so I'd advise against it.
-   Submitting anything other than a JPEG with a post will break. For whatever reason, CodeIgniter's image library decided
    not to support PNGs (despite them having network in the name, I mean come on) or anything else, so make sure you submit
    a JPEG.
-   Not sure if this still happens, but occasionally the home page displays warnings about invalid foreach
    arguments. I added a var_dump to see what was passed in, and nothing looked wrong. Upon taking away the
    var_dump with no other changes to any portion of the site, the issue fixed itself. This happened about 3
    times, and I have no idea why.

Administrative
-   Your admin username is JPARRY and your password is J123yarryp
-   Your user-level username is ParryJ and your password is Parry3_3_J

Criteria
-   Implemented
    *   Comments (writing and display)
    *   Post uploading with image support (must be .jpg)
    *   XML-RPC (all aspects)
    *   User maintenance
    *   Post maintenance
    *   Site maintenance (allows for changing of the site's plug and title for syndication)
    *   Complete data: 15 posts with some comments
    *   Pagination - doesn't have tagging support, but it's possible to navigate
    *   Works properly (mostly): some parts are a bit fragile since they don't have strict
        input validation, but it works the majority of the time

-   Not implemented
    *   Extra XSL transformations
 