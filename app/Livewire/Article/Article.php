<?php

namespace App\Livewire\Article;

use App\Models\File;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Storage;
use App\Models\Article as ModelsArticle;

class Article extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        return view('livewire.article.article',[
            'articles' => ModelsArticle::paginate(10),
        ])
        ->title('Article');
    }

    public function openArticleForm()
    {
        $this->dispatch('open-article-form');
    }

    #[On('load-data-article')]
    public function loadData()
    {
        $articles = ModelsArticle::all();
    }
    
    public function editArticle($id)
    {
        $this->dispatch('edit-article', id: $id);
    }

    public function delete($id)
    {

        $unusedFiles = File::select('id', 'location')
            ->doesntHave('articleImages')
            ->get();

        try {
            DB::beginTransaction();

            $article = ModelsArticle::findOrFail($id);

            foreach ($article->articleImages as $image) {
                if (!empty($image->file_id)) {
                    $oldFileName = $image->file->location;
                }

                if (isset($oldFileName)) {
                    Storage::delete($oldFileName);
                }

                if (!$unusedFiles->isEmpty()) {
                    foreach ($unusedFiles as $file) {
                        $file->delete();
                    }
                }

                $file = File::findOrFail($image->file->id)->delete();
            }

            $article->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            $this->dispatch('open-alert', status: 'error', message: 'Error :' . $th->getMessage());
        }

        $this->dispatch('open-alert', status: 'success', message: 'Article successfully deleted.');
    }
}
