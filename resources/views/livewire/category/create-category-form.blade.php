<div class="">
@if ($isOpen)
<div class="modal-backdrop fade show"></div>

<div class="modal fade show" tabindex="-1" style="display: block;">
    <div class="modal-dialog modal-lg modal-fullscreen-lg-down modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Category</h5>
                <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form wire:submit.prevent="save">
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            Title
                            <span class="required text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('title') is-invalid @enderror" 
                            id="title" 
                            wire:model="title"
                        >
                        @error('title') 
                            <span class="error">{{ $message }}</span> 
                        @enderror
                    </div>

                </form>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-light text-dark me-auto" wire:click="closeModal">Close</button>
                <button type="button" class="btn btn-success" wire:click="save">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

@endif
</div>