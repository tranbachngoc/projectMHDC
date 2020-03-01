<ul>
    {foreach $sort as $sItem}
        <li style="display: inline-block; margin-right: 10px;"><a href="{$sItem.link}">{$sItem.text}</a></li>
    {/foreach}
</ul>
<form action="{$link}" method="post" class="searchBox">

    <select name="status" autocomplete="off">
        <option value="">Tất cả</option>
        {foreach $status as $sta}
            <option value="{$sta.id}" {if $filter.status == $sta.id}selected="selected"{/if}>{$sta.text}</option>
        {/foreach}
    </select>
    <select name="type" autocomplete="off">
        <option value="">Tất cả</option>
        {foreach $types as $type}
            <option value="{$type.id}" {if $filter.type == $type.id}selected="selected"{/if}>{$type.text}</option>
        {/foreach}
    </select>
    Ngày từ: <input type="text" name="df" value="{$filter.df}" placeholder="yyyy-mm-dd" autocomplete="off"/>
    đến <input type="text" name="dt" value="{$filter.dt}" placeholder="yyyy-mm-dd" autocomplete="off"/>
    <input type="submit" value="Tìm kiếm">
    <input type="hidden" name="dir" value="{$filter.dir}"/>
    <input type="hidden" name="sort" value="{$filter.sort}"/>
</form>
<table border="1">
    <thead>
    <td>Amount</td>
    <td>Type</td>
    <td>Status</td>
    <td>Date</td>
    </thead>
    <tbody>
    {foreach $orders as $order}
        <tr>
            <td>{$order.commission}</td>
            <td>{$order.type}</td>
            <td>{$order.status}</td>
            <td>{$order.created_date}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
<div class="pagination">
    {$pager}
</div>