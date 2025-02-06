<div class="container">
    <div class="row">
        <div class="col-xl-10 text-center mb-3">
            <div class="card mt-5">
                @foreach ($articles as $article)
                <div class="card-header">
                    {{ $article->title }}
                </div>
                <div class="card-body">
                   <div class="card-title">
                        <img src="{{ url('image/placehold600x400.png') }}" alt="article-image">
                   </div>
                    <div class="card-text mb-2 mt-2">
                        {{ Str::words($article->description) }}
                    </div>
                    <div class="card-footer text-muted">
                        <p>Uploaded: {{ $article->created_at->diffForHumans() }}. Author: {{ $article->user->name }}</p>  
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
