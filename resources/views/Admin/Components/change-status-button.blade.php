<div class="d-flex flex-column align-items-center">
    <div class="form-check form-switch form-check-primary">
        <input type="checkbox" class="form-check-input" name="changeStatus" id="{{ $item->id }}"
            {{ $item->deleted_at ? null : 'checked=checked' }} />
    </div>
</div>
