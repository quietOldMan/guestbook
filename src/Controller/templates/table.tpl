<h4>Что говорят другие</h4>
<div class="row">
    {if $Count > 25}
        <div class="btn-group justify-content-between" role="group" aria-label="Pagination">
            <button type="button" class="btn btn-secondary btn-sm">Первая</button>
            <button type="button" class="btn btn-secondary btn-sm">Предыдущая</button>

            <button type="button" class="btn btn-outline-primary" disabled>{$Page}</button>

            <button type="button" class="btn btn-secondary btn-sm">Следующая</button>
            <button type="button" class="btn btn-secondary btn-sm">Последняя</button>
        </div>
    {/if}
</div>
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