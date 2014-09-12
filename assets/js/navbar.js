$(document).ready(
  function() {
      $("#header ul li a").hoverIntent(
         {over:function() {
                    $("#brace-left-" + $(this).attr("class")).animate(
                        {opacity:'1', display:'inline', fontSize:'1.5em', zIndex:'2'}
                    );
                    $("#brace-right-" + $(this).attr("class")).animate(
                        {opacity:'1', display:'inline', fontSize:'1.5em', zIndex:'2'}
                    );
                },
          out:function(){
              $("#brace-left-" + $(this).attr("class")).animate(
                  {opacity:'0', display:'none'}
              );
              $("#brace-right-" + $(this).attr("class")).animate(
                  {opacity:'0', display:'none'}
              ); 
          },
          interval:25
         }
      );
   }
);