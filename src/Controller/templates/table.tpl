<h4>Что говорят другие</h4>
{foreach from=$Records item=r}
    <div class="row">
        <table class="table table-borderless table-sm">
            <tbody>
            <tr>
                <td>
                    <strong>{$r.userName}</strong>
                </td>
            </tr>
            <tr>
                <td>
                    <small class="text-muted">{$r.createTime|date_format:"%e %b %Y at %k:%M"}</small>
                </td>
            </tr>
            <tr class="table-info">
                <td>
                    {$r.text}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <hr class="mt-2 mb-3">
{/foreach}