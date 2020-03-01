<html>
  <head>
    <title><?= $content->not_title ?></title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@0.6.2/build/pure-min.css" integrity="sha384-UQiGfs9ICog+LwheBSRCt1o5cbyKIHbwjWscjemyBMT9YCUMZffs6UqUTd0hObXD" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdn.ckeditor.com/4.6.2/standard-all/contents.css?t=H0CF">
  </head>
  <body>
    <div class="pure-u" style="width: 100%">
        <?php
          echo html_entity_decode($content->not_detail);
        ?>
    </div>
  </body>
</html>
