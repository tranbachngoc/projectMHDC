<ul>
    <li><a href="{$productLink}">Danh sách sản phẩm</a></li>
    <li><a href="{$myproductsLink}">Sản phẩm của tôi</a></li>
</ul>
<ul>
    {foreach $sort as $sItem}
        <li style="display: inline-block; margin-right: 10px;"><a href="{$sItem.link}">{$sItem.text}</a></li>
    {/foreach}
</ul>
<form action="{$link}" method="post" class="searchBox">

    <select name="cat" autocomplete="off">
        <option value="0">Tất cả</option>
        {foreach $category as $cat}
            <option value="{$cat.cat_id}" {if $filter.cat == $cat.cat_id}selected="selected"{/if}>{$cat.cat_name}</option>
        {/foreach}
    </select>
    Giá từ: <input type="text" name="pf" value="{$filter.pf}" />
    đến <input type="text" name="pt" value="{$filter.pt}" />
    <input type="text" name="q" value="{$filter.q}" placeholder="Nhập từ khóa">
    <input type="submit" value="Tìm kiếm">
    <input type="hidden" name="dir" value="{$filter.dir}" />
    <input type="hidden" name="sort" value="{$filter.sort}" />
</form>
<ul class="afBox">
    {foreach $products as $product}
        <li id="af_row_{$product.pro_id}">{$product.pro_name} | Giá: {$product.pro_cost} | AF amt: {$product.af_amt} |
            AF rate: {$product.af_rate}
            | Category: {$product.cName}
            | AF link: <a href="{$product.link}">link</a>
            <span
                    style="font-weight: bold; display: inline-block; float: right; cursor: pointer;"
                    class="item {if $product.isselect == TRUE}selected{/if}"
                    class="pItem">{if $product.isselect == TRUE}Xóa{else}Thêm{/if}</span></li>
    {/foreach}
</ul>
<div class="pagination">
    {$pager}
</div>