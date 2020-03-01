<ul>
    {foreach $sort as $sItem}
        <li style="display: inline-block; margin-right: 10px;"><a href="{$sItem.link}">{$sItem.text}</a></li>
    {/foreach}
</ul>
<form action="{$link}" method="post" class="searchBox">

    <select name="status" autocomplete="off">
        <option value="">Tất cả</option>
        {foreach $status as $sta}
            <option value="{$sta.status_id}" {if $filter.status == $sta.status_id}selected="selected"{/if}>{$sta.text}</option>
        {/foreach}
    </select>
    Giá từ: <input type="text" name="df" value="{$filter.df}" placeholder="yyyy-mm-dd" autocomplete="off" />
    đến <input type="text" name="dt" value="{$filter.dt}"  placeholder="yyyy-mm-dd" autocomplete="off" />
    <input type="submit" value="Tìm kiếm">
    <input type="hidden" name="dir" value="{$filter.dir}" />
    <input type="hidden" name="sort" value="{$filter.sort}" />
</form>
<table border="1">
    <thead>
    <td>Order Id</td>
    <td>Product</td>
    <td>Price</td>
    <td>qty</td>
    <td>AF Amt</td>
    <td>AF rate</td>
    <td>Update date</td>
    <td>Status</td>
    </thead>
    <tbody>
{foreach $orders as $order}
   <tr>
       <td>{$order.id}</td>
       <td>{$order.pName}</td>
       <td>{$order.pro_price}</td>
       <td>{$order.qty}</td>
       <td>{$order.af_amt}</td>
       <td>{$order.af_rate}</td>
       <td>{$order.createdDate}</td>
       <td>{$order.pState}</td>
   </tr>
{/foreach}
    </tbody>
</table>
<div class="pagination">
    {$pager}
</div>