<?php

namespace App\Livewire\Article;

use App\Models\Article;
use App\Models\Category;
use App\Models\File;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateArticleForm extends Component
{
    use WithFileUploads;

    public $user, $category, $title, $description, $articleId,
        $images = [], $isOpen = false;

    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'user' => 'required|exists:users,id',
            'category' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'images.*' => 'nullable|image|max:2048'
        ];
        
        if (!empty($this->articleId)) {
            $rules['user'] = 'nullable|exists:users,id';
            $rules['category'] = 'nullable|exists:categories,id';
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();
        
        $listImages = [];

        try {
            DB::beginTransaction();

            if (empty($this->articleId)) {
                $article = Article::create([
                    'user_id' => $this->user,
                    'category_id' => $this->category,
                    'title' => $this->title,
                    'description' => $this->description
                ]);

                // Check upload images.
                if (!empty($this->images)) {

                    // Looping images, store image, and create a File data.
                    foreach ($this->images as $image) {
                        $path = $image->store('articles', 'public');
                        $file = File::create([
                            'location' => $path
                        ]);

                        $listImages[] = [
                            'article_id' => $article->id,
                            'file_id' => $file->id
                        ];
                    }
                    
                    // Create all data images to ArticleImage.
                    $article->articleImages()->createMany($listImages);
                }
                
                $this->dispatch('open-alert', status: 'success', message: 'Article successfully created.');
            } else {
                $article = Article::findOrFail($this->articleId);

                $data = $this->only([
                    'title', 'description'
                ]);

                $data['user_id'] = $this->user;
                $data['category_id'] = $this->category;
                
                $article->update($data);

                // Check upload images.
                if (!empty($this->images)) {

                    // Check old images.
                    if ($article->articleImages) {
                        $fileIds = $article->articleImages->pluck('file_id')->toArray();
                        
                        // Delete old images.
                        $allNameFiles = File::whereIn('id', $fileIds)->pluck('location')->toArray();
                        Storage::delete($allNameFiles);

                        // Delete old File data.
                        $files = File::whereIn('id', $fileIds)->delete();

                        // Delete old Article Image data.
                        $article->articleImages()->delete();
                    }

                    // Looping images, store image, and create a File data.
                    foreach ($this->images as $image) {
                        $path = $image->store('articles', 'public');
                        $file = File::create([
                            'location' => $path
                        ]);

                        $listImages[] = [
                            'article_id' => $this->articleId,
                            'file_id' => $file->id
                        ];
                    }
                    
                    // Create all data images to ArticleImage.
                    $article->articleImages()->createMany($listImages);
                }

                $this->dispatch('open-alert', status: 'success', message: 'Articles successfully updated.');
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            
            $this->dispatch('open-alert', status: 'error', message: 'Error: ' . $th->getMessage());
        }
        
        $this->closeModal();
        $this->dispatch('load-data-article');
    }

    public function render()
    {
        return view('livewire.article.create-article-form', [
            'users' => User::all(),
            'categories' => Category::all()
        ]);
    }
    
    #[On('open-article-form')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset([
            'title', 'category', 'user', 'description', 
            'images', 'articleId'
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
