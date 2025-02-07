<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class CreateCategoryForm extends Component
{
    public $title, $isOpen = false, $categoryId;
    
    public function save()
    {
        try {
            DB::beginTransaction();

            if (empty($this->categoryId)) {
                $category = Category::create($this->only('title'));
            } else {
                $category = Category::findOrFail($this->categoryId);

                $category->update($this->only('title'));
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            $this->dispatch('open-alert', status: 'error', message: 'Error' . $th->getMessage());
        }

        $this->closeModal();
        $this->dispatch('load-data-category');
    }

    public function render()
    {
        return view('livewire.category.create-category-form', [
            'categories' => Category::all()
        ]);
    }

    #[On('open-category-form')]
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset([
            'title'
        ]);
        $this->resetValidation();
    }

    #[On('edit-category')]
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->title = $category->title;
        
        $this->openModal();
    }

}
