<?php

function bootstraphead($loadbootstrap) {
echo "<!DOCTYPE html>";
echo "<html lang='de'>";
echo "<head>";
echo "<meta charset='utf-8'>";
echo "<link href='../includes/bootstrap/css/bootstrap.css' rel='stylesheet'>";

echo "<link href='../includes/Slider/fullscreenstyle.css' type='text/css' rel='stylesheet'></link>";
echo "<link href='../includes/Slider/pagestyle.css' type='text/css' rel='stylesheet'></link>";
echo "<link href='http://www.jqueryscript.net/css/jquerysctipttop.css' rel='stylesheet' type='text/css'>";
echo "<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>";
echo "<script src='../includes/Slider/jquery.fullscreenslides.js'></script>";
?>
<script id="sample">
$(function(){
  // initialize the slideshow
  $('.image img').fullscreenslides();
  
  // All events are bound to this container element
  var $container = $('#fullscreenSlideshowContainer');
  
  $container
    //This is triggered once:
    .bind("init", function() { 

      // The slideshow does not provide its own UI, so add your own
      // check the fullscreenstyle.css for corresponding styles
      $container
        .append('<div class="ui" id="fs-close">&times;</div>')
        .append('<div class="ui" id="fs-loader">Loading...</div>')
        .append('<div class="ui" id="fs-prev">&lt;</div>')
        .append('<div class="ui" id="fs-next">&gt;</div>')
        //.append('<div class="ui" id="fs-caption"><span></span></div>');
      
      // Bind to the ui elements and trigger slideshow events
      $('#fs-prev').click(function(){
        // You can trigger the transition to the previous slide
        $container.trigger("prevSlide");
      });
      $('#fs-next').click(function(){
        // You can trigger the transition to the next slide
        $container.trigger("nextSlide");
      });
      $('#fs-close').click(function(){
        // You can close the slide show like this:
        $container.trigger("close");
      });
      
    })
    // When a slide starts to load this is called
    .bind("startLoading", function() { 
      // show spinner
      $('#fs-loader').show();
    })
    // When a slide stops to load this is called:
    .bind("stopLoading", function() { 
      // hide spinner
      $('#fs-loader').hide();
    })
    // When a slide is shown this is called.
    // The "loading" events are triggered only once per slide.
    // The "start" and "end" events are called every time.
    // Notice the "slide" argument:
    .bind("startOfSlide", function(event, slide) { 
      // set and show caption
      $('#fs-caption span').text(slide.title);
      $('#fs-caption').show();
    })
    // before a slide is hidden this is called:
    .bind("endOfSlide", function(event, slide) { 
      $('#fs-caption').hide();
    });
});
</script>
<?php

echo "<title>Joorgsqlite</title>";
echo "</head>";
}

function bootstrapbegin($headline,$showheadline) {
  echo "<body>";
  echo "<div class='row-fluid'>";
  echo "<div class='span12'>";
  //echo "<h1 align='center'>".$headline."</h1>";
  if ($headline<>"") {
    echo "<legend>".$headline."</legend>";
  }
}

function bootstrapend() {
  echo "</div>";
  echo "</div>";
  echo "</body>";
  echo "</html>";
}

?>