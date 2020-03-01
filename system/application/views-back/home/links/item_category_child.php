<?php
if(!empty($category_slug) && $category_slug == $category['slug']){
    echo '<span class="is-active" data-id="'. $category['id'] .'">'. ucfirst($category['name']) .'</span>';
}else{
    echo '<a href="'.$domain_url.'/links/'.$category['slug'].'">';
    echo '  <span data-id="'. $category['id'] .'">'. ucfirst($category['name']) .'</span>';
    echo '</a>';
}
?>