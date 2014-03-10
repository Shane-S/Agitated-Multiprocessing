$().ready(function() {
    var opts = {
        lang         : 'en',   // set your language
        styleWithCSS : false,
        toolbar      : 'maxi',
        height       : '12em'
    };
    // create editor
    $('#post_content').elrte(opts);
});