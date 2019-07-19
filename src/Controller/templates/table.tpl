<h4>Что говорят другие</h4>
<div class="row">
    {if $Page.maxPage > 1}
        <div class="btn-group justify-content-between" role="group" aria-label="Pagination">
            <button type="button" class="btn btn-secondary btn-sm" id="pageFirst">Первая</button>
            <button type="button" class="btn btn-secondary btn-sm" id="pagePrev"
                    value="{if $Page.currentPage > 1}{$Page.currentPage - 1}{elseif $Page.currentPage === 1}{$Page.currentPage}{/if}">
                Предыдущая
            </button>
            <button type="button" class="btn btn-outline-primary" disabled
                    value="{$Page.currentPage}">{$Page.currentPage}</button>
            <button type="button" class="btn btn-secondary btn-sm" id="pageNext"
                    value="{if $Page.maxPage > $Page.currentPage}{$Page.currentPage + 1}{elseif $Page.maxPage == $Page.currentPage}{$Page.maxPage}{/if}">
                Следующая
            </button>
            <button type="button" class="btn btn-secondary btn-sm" id="pageEnd" value="{$Page.maxPage}">Последняя
            </button>
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