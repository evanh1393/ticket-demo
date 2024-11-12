{{-- resources/views/filament/components/custom-table.blade.php --}}
<div>
    {{ $table->renderTable() }}
    <div class="filament-tables-pagination">
        <span>
            Showing {{ $table->getRecords()->firstItem() }} to {{ $table->getRecords()->lastItem() }} of {{ $table->getRecords()->total() }} results
        </span>
    </div>
</div>
