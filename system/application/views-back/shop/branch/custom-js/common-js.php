<script>
  function error_image(image) {
    default_image_error_path = '/templates/home/styles/avatar/default-avatar.png';
    $(image).attr('src', default_image_error_path);
  }

  function error_image_banner(image) {
    default_image_error_path = '/templates/home/styles/images/cover/cover_me.jpg';
    $(image).attr('src', default_image_error_path);
  }
</script>