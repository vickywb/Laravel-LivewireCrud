<?php

namespace App\Livewire\Article;

use App\Models\Article;
use App\Models\Category;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateArticleForm extends Component
{
    use WithPagination, WithFileUploads;
    
    public $user, $title, $description, $category, $images = [], $articleId, 
        $isOpen = false, $fileId, $location, $article;
    
    public function save()
    {
        $listImages = [];

        dd($this->user);

        $unusedFiles = File::select('id', 'location')
            ->doesntHave('articleImages')
            ->get();

        try {
            DB::beginTransaction();

            if (empty($this->articleId)) {
                
                $article = Article::create([
                    'user_id' => $this->user,
                    'category_id' => $this->category,
                    'title' => $this->title,
                    'description' => $this->description
                ]);
                
                $articleId = $article->id;

                foreach ($this->images as $image) {

                    $path = $image->store('articles', 'public');

                    $file = File::create([
                        'location' => $path
                    ]);

                    $fileId = $file->id;

                    $listImages[] = [
                        'file_id' => $fileId,
                        'article_id' => $articleId
                    ];
                }

                $article->articleImages()->createMany($listImages);

                $this->dispatch('open-alert', status: 'success', message: 'Article successfully created.');
            } else {
                $article = Article::findOrFail($this->articleId);

                $data = $this->only([
                    'title', 'category', 'user', 'description'
                ]);
                
                $article->update($data);

                foreach ($this->images as $image) {
                    $path = $image->store('articles', 'public');

                    $file = File::create([
                        'location' => $path
                    ]);

                    $fileId = $file->id;

                    $listImages[] = [
                        'file_id' => $fileId,
                        'article_id' => $article->id
                    ];

                    if (!empty($article->articleImages)) {
                        foreach ($article->articleImages as $articleImage) {
                            if ($articleImage->file_id) {
                                $oldFileName = $articleImage->file->location;
                            }
    
                            if (isset($oldFileName)) {
                                Storage::delete($oldFileName);
                            }
    
                            if (!$unusedFiles->isEmpty()) {
                                foreach ($unusedFiles as $unusedFile) {
                                    $unusedFile->delete();
                                }
                            }
    
                            $deleteFile = File::findOrFail($articleImage->file->id)->delete();
                        }
                    }
                }

                $article->articleImages()->createMany($listImages);
               
                $this->dispatch('open-alert', status: 'success', message: 'Articles successfully updated.');
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            $this->dispatch('open-alert', status: 'error', message: 'Error: ' . $th->getMessage());
        }

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.article.create-article-form', [
            'articles' => Article::all(),
            'users' => User::all(),
            'categories' => Category::all()
        ]);
    }
    
    #[On('open-article-form')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    // public function resetModal()
    // {
    //    $this->reset([
    //         'title', 'category', 'user', 'description', 'images'
    //     ]);
    //     $this->resetValidation();
    // }

    public function closeModal()
    {
        $this->isOpen = false;
           $this->reset([
            'title', 'category', 'user', 'description', 'images'
        ]); 
        $this->resetValidation();
    }

    #[On('edit-article')]
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $this->articleId = $article->id;
        $this->user = $article->user_id;
        $this->title = $article->title;
        $this->category = $article->category_id;
        $this->description = $article->description;
        $this->images = $article->images;
        
        $this->openModal();
    }
}
