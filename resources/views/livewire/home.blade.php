<div class="container">
    <div class="row">
        <div class="col-xl-12 text-center mb-3">
            <div class="card mt-5">
                @foreach ($articles as $article)
                <div class="card-header">
                    {{ $article->title }}
                </div>
                <div class="card-body w-50 h-50">
                   <div class="card">
                        <img src="{{ $article->firstImage->showFile ?? asset('image/placehold600x400.png') }}" alt="article-image" style="object-fit: cover">
                   </div>
                    <div class="card-text mb-2 mt-2">
                        {{ Str::words($article->description) }}
                    </div>
                    <div class="card-footer text-muted">
                        <p>Uploaded: {{ $article->dateTime }}. Author: {{ $article->user->name }}</p>  
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>