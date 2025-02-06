<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\Category as ModelsCategory;

class Category extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        return view('livewire.category.category', [
            'categories' => ModelsCategory::paginate(4)
        ])
        ->title('Category');
    }

    public function openCategoryForm()
    {
        $this->dispatch('open-category-form');
    }

    #[On('load-data-category')]
    public function loadData()
    {
        $categories = ModelsCategory::all();
    }
}
