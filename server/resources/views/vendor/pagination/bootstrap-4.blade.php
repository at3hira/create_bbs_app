@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- First Page Link --}}
            <li class="page-item {{ $paginator->onFirstPage() ? ' disabled' : ''}}">
                <a class="page-link" href="{{ $paginator->url(1) }}">&laquo</a>
            </li>
            {{-- Pagination Elements --}}
                {{-- Array Of Links --}}
                {{-- 定数よりもページ数が多い時 --}}
                @if ($paginator->lastPage() > config('view.PAGINATE.LINK_NUM'))
                    
                    {{-- 現在のページが表示するリンクの中心位置よりも左の時 --}}
                    @if ($paginator->currentPage() <= floor(config('view.PAGINATE.LINK_NUM') / 2))
                        <?php $start_page = 1; ?>
                        <?php $end_page = config('view.PAGINATE.LINK_NUM'); ?>

                    {{-- 現在のページが表示するリンクの中心位置よりも右の時 --}}
                    @elseif ($paginator->currentPage() > $paginator->lastPage() - floor(config('view.PAGINATE.LINK_NUM') / 2))
                        <?php $start_page = $paginator->lastPage() - (config('view.PAGINATE.LINK_NUM') - 1); ?>
                        <?php $end_page = $paginator->lastPage(); ?>

                    {{-- 現在のページが表示するリンクの中心の時 --}}
                    @else
                        <?php $start_page = $paginator->currentPage() - (floor((config('view.PAGINATE.LINK_NUM') % 2 == 0 ? config('view.PAGINATE.LINK_NUM') -1 : config('view.PAGINATE.LINK_NUM')) / 2)); ?>
                        <?php $end_page = $paginator->currentPage() + floor(config('view.PAGINATE.LINK_NUM') / 2); ?>
                    @endif
                
                {{-- 定数よりもページ数が少ない時 --}}
                @else
                    <?php $start_page = 1; ?>
                    <?php $end_page = $paginator->lastPage(); ?>
                @endif

                {{-- 処理部分 --}}
                @for ($i = $start_page; $i <= $end_page; $i++)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

            {{-- Last Page Link --}}
            <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? ' disabled' : ''}}">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">&raquo;</a>
            </li>
        </ul>
    </nav>
@endif
