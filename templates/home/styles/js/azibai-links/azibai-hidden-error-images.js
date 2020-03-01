function image_error(img, selector)
{
    if(typeof selector !== 'undefined'){
        var el = document.querySelector(selector);
        if(el){
            el.remove();
            console.log('image 404', img.getAttribute('src'));
            return;
        }
    }
    img.setAttribute('src', default_image_error_path);
    img.className += ' error-image ';
}