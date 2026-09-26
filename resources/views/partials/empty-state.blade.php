{{-- Pakai: @include('partials.empty-state', ['colspan' => 5, 'message' => 'Belum ada data kategori.']) --}}

<tr>
    <td colspan="{{ $colspan ?? 5 }}" class="text-center py-4">
        <div class="text-muted">
            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
            {{ $message ?? 'Belum ada data.' }}
        </div>
    </td>
</tr>