<div class="container">
    <div class="row">
       
        <div class="d-flex flex-row-reverse pt-3">
          <button 
          type="button" 
          class="btn btn-sm btn-primary mb-3" 
          wire:click="openArticleForm"
          >
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
          </svg>
              Add New Article
          </button>

          <livewire:article.create-article-form>
        </div>

        {{-- <livewire:component.alert> --}}

        <div class="table-responsive">
          <table class="table table-hover table-bordered mt-3">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Category</th>
                <th scope="col">Image</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            @foreach ($articles as $article)
              <tbody>
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $article->title }}</td>
                  <td>{{ $article->category->title }}</td>
                  <td><img src="{{ $article->firstImage->showFile ?? asset('image/placehold600x400.png') }}" alt="{{ lcfirst($article->title) }}" width="125px"></td>
                  <td>{{ Str::words($article->description, 5, '...') }}</td>
                  <td>
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary"
                        wire:click="editArticle({{ $article->id }})"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                    </button>
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-danger"
                        wire:click="delete({{ $article->id }})"
                        wire:confirm="Are you sure you want to delete this Article?"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                        </svg>
                    </button>
                </td>
                </tr>
              </tbody>
            @endforeach
          </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
          {{ $articles->links() }}
      </div>
    </div>
</div>
