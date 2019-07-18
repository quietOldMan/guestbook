{include file="header.tpl"}
<h1>Добро пожаловать!</h1>
<h2>Список отзывов, предложений, лести и брани</h2>
<table style="width:100%">
    {foreach from=$Records item=r}
    <td>
        <tr>
            <td>{$r.userName}</td>
            <td>{$r.email}</td>
        </tr>
        <tr>
            <td colspan="2">{$r.createTime|date_format:"%e %b %Y at %k:%M"}</td>
        </tr>
        <tr>
            {textformat wrap=40}
            <td colspan="2">{$r.text}</td>
            {/textformat}
        </tr>
    </td>
    {/foreach}
</table>
{include file="footer.tpl"}