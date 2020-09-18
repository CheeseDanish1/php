<?php
  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  if (strpos($actual_link, "footer")) {
    include_once 'error-pages/404.html';
    //header("Location: index");
  } else {
    ?>
<footer>
    <p>Icons made by <a href="https://www.flaticon.com/authors/roundicons" title="Roundicons">Roundicons</a> from
        <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a>
    </p>
</footer>
<?php
  }
?>