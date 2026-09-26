@if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
<div class="d-flex justify-content-between align-items-center mt-2">
    <small class="text-muted">
        Menampilkan {{ $data->firstItem() ?? 0 }}–{{ $data->lastItem() ?? 0 }}
        dari {{ $data->total() }} data
    </small>
    <div>{{ $data->links() }}</div>
</div>
@endif