<?php
$category_parent         = [];
$html_submenu_temp       = '';
$html_item_temp          = '';
$item_temp_first         = '';
$item_temp_last          = '';
$temp_parent_id          = 0;
$html_wrap_item_temp_cat = '';

if (!empty($links) && !empty($categories_parent)){
    $total_link = count($links);
    foreach ($links as $key_link => $link) {

        if($link['noo'] != 1){
            //load item nối chuỗi html.
            $html_item_temp .= $this->load->view('shop/media/elements/library-links/library-item-v2', [
                'item'          => $link,
                'server_media'  => $server_media,
                'is_owns'       => $is_owns,
                'url_item'      => $url_item,
            ], true);

            if(($link['noo'] - 1) % 5 == 0){
                $html_wrap_item_temp_cat .= '<div class="item-slider '.$key_link.'">';
                $html_wrap_item_temp_cat .= $html_item_temp;
                $html_wrap_item_temp_cat .= '</div>';
                $html_item_temp          = '';
            }
        }

        //get subcategory
        if(!isset($categories_parent[$link['cate_id']]['child'][$link['cate_link_id']])){
            $categories_parent[$link['cate_id']]['child'][$link['cate_link_id']] = [
                'id'        => $link['cate_link_id'],
                'name'      => $link['name'],
                'slug'      => $link['slug'],
                'parent_id' => $link['parent_id'],
            ];
        }

        if(($temp_parent_id && $temp_parent_id != $link['cate_id']) || ($total_link - 1) == $key_link){
            if($html_item_temp && $item_temp_last && ($item_temp_last['noo'] - 1) % 5 != 0){
                $html_wrap_item_temp_cat .= '<div class="item-slider '.$key_link.'">';
                $html_wrap_item_temp_cat .= $html_item_temp;
                $html_wrap_item_temp_cat .= '</div>';
                $html_item_temp          = '';
            }

            if(!$item_temp_first){
                //total link = 1
                $item_temp_first = $link;
            }

            //category tat ca
            $cat_all = $this->load->view('shop/media/elements/library-links/item_category_child', [
                'category'   => [
                    'name' => 'Tất cả',
                    'slug' => 'tat-ca',
                    'id'   => '',
                ],
                'domain_url'    => $url_item . 'library',
                'category_slug' => 'tat-ca',
            ], true);


            //load child nối chuỗi html.
            foreach ($categories_parent[$item_temp_first['cate_id']]['child'] as $cat_child) {
                $html_submenu_temp .= $this->load->view('shop/media/elements/library-links/item_category_child', [
                    'category'   => $cat_child,
                    'domain_url' => $url_item . 'library',
                ], true);
            }

            $this->load->view('shop/media/elements/library-links/item_block_link_category', [
                'domain_url'   => $url_item,
                'category'     => @$categories_parent[$item_temp_first['cate_id']],
                'html_submenu' => $cat_all . $html_submenu_temp,
                'html_item'    => $html_wrap_item_temp_cat,
                'item'         => $item_temp_first,
            ]);

            $html_submenu_temp = '';
        }

        if($link['noo'] == 1){
            $item_temp_first         = $link;
            $html_item_temp          = '';
            $html_wrap_item_temp_cat = '';
        }
        $item_temp_last  = $link;
        $temp_parent_id  = $link['cate_id'];
    }
}
?>