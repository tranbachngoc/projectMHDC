<?php if((!empty($category_parent) && $category_parent['slug'] == $category['slug'] ? 'active' : '')){ ?>
    <span class="is-active" style="font-size: 16px;"><?php echo ucfirst($category['name']); ?></span>
<?php }else{ ?>
    <a href="<?php echo $domain_url .'/links/'. $category['slug'] ?>" title="<?php echo $category['name'] ?>">
        <span class="text"><?php echo ucfirst($category['name']); ?></span>
    </a>
<?php } ?>