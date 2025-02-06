<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;

class CreateCategoryForm extends Component
{
    public $title, $isOpen = false;
    
    public function save()
    {
        $data = $this->only('title');
        Category::create($data);

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

}
