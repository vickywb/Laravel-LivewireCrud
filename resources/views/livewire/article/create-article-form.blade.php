<div class="">
    @if ($isOpen)
        <div class="modal-backdrop fade show"></div>
        
        <div class="modal fade show" tabindex="-1" style="display: block;">
            <div class="modal-dialog modal-lg modal-fullscreen-lg-down modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">New Article</h5>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    
                    <livewire:component.alert>
                        
                    <form wire:submit.prevent="save">
                     
                        <div class="modal-body">

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

                                <div class="col-md-6">
            
                                    <div class="mb-3">
                                        <label for="user" class="form-label">
                                            Author
                                            <span class="required text-danger">*</span>
                                        </label>
                                        <select 
                                            class="form-select @error('user') is-invalid @enderror" 
                                            wire:model="user"
                                        >
                                            <option>Select Author</option>
                                            @foreach ($users as $user)
                                                <option value={{ $user->id }} selected>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user') 
                                            <span class="error">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="category" class="form-label">
                                            Category
                                            <span class="required text-danger">*</span>
                                        </label>
                                        <select 
                                            class="form-select @error('category') is-invalid @enderror" 
                                            wire:model="category"
                                        >
                                            <option>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value={{ $category->id }} selected>{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('category') 
                                            <span class="error">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="mb-3">
                                    <input type="file" wire:model="images" multiple>
                                    @error('images.*') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            
                                <div class="mb-3">
                                    <label for="description" class="form-label">
                                        Description
                                        <span class="required text-danger">*</span>
                                    </label>
                                    <textarea class="form-control  @error('description') is-invalid @enderror" placeholder="Leave a comment here" id="description" wire:model="description"></textarea>
                                    @error('description') 
                                        <span class="error">{{ $message }}</span> 
                                    @enderror
                                </div>
                        </div>
            
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-light text-dark me-auto" wire:click="closeModal">Close</button>
                            
                            <button type="submit" class="btn btn-success" wire:click="save">
                                Save
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        
    @endif
</div>