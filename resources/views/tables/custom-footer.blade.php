{{-- resources/views/tables/custom-footer.blade.php --}}
<div class="filament-tables-pagination">
    <span>
        Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of {{ $records->total() }} results
    </span>
</div>
