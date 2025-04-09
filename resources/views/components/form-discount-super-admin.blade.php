<div class="mb-3 d-flex justify-content-end ">
    <div class="form-check form-switch d-flex align-items-center">
        <input class="form-check-input" type="checkbox" id="all_branches"
            name="all_branches" value="{{ $discount->all_branches ?? false }}">
        <label class="form-check-label mb-0 ms-3" for="all_branches">All Branch</label>
    </div>
</div>
    <div class="mb-3" id="branches_selection">
        <label class="form-label">Branch Name</label>
        <select name="branches_id" id="branches_id"
            class="form-select select2 bg-transparent border p-2">
            <option value="" selected disabled >Select and search</option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}" {{ $branch->id == ($discount->branches_id ?? '') ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" id="status"
            class="form-select select2 bg-transparent border p-2">
            <option value="" selected disabled >-- Select and search --</option>
            <option value="active" {{ ($discount->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive"  {{ ($discount->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>

        </select>
    </div>
