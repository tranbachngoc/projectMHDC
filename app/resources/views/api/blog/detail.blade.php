<html>
  <head>
    <title><?= $blog->title ?></title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@0.6.2/build/pure-min.css" integrity="sha384-UQiGfs9ICog+LwheBSRCt1o5cbyKIHbwjWscjemyBMT9YCUMZffs6UqUTd0hObXD" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdn.ckeditor.com/4.6.2/standard-all/contents.css?t=H0CF">
  </head>
  <body>
  	@if ($blog->image)
  	<div class="pure-u-1">
        <img class="pure-img" src="{{$blog->getImageUrl()}}">
    </div>
    @endif
    <div class="pure-u" style="width: 100%">
        <?= $blog->description ?>
    </div>
  </body>
</html>
