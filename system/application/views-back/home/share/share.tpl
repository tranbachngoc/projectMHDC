<ul>
    {foreach $sort as $sItem}
        <li style="display: inline-block; margin-right: 10px;"><a href="{$sItem.link}">{$sItem.text}</a></li>
    {/foreach}
</ul>
<form action="{$link}" method="post" class="searchBox">

    <input type="text" name="q" value="{$filter.q}" placeholder="Nhập từ khóa( tên, user name, email)">

    <input type="submit" value="Tìm kiếm">
    <input type="hidden" name="dir" value="{$filter.dir}" />
    <input type="hidden" name="sort" value="{$filter.sort}" />
</form>
<table border="1">
    <thead>
    <td>Name</td>
    <td>Username</td>
    <td>Email</td>
    <td>Link</td>
    <td>Count</td>

    </thead>
    <tbody>
    {foreach $list as $item}
        <tr>
            <td>{$item.use_fullname}</td>
            <td>{$item.use_username}</td>
            <td>{$item.use_email}</td>
            <td>{$item.link}</td>
            <td>{$item.click}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
<div class="pagination">
    {$pager}
</div>