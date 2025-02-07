<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\WithoutUrlPagination;
use App\Models\Category as ModelsCategory;

class Category extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        return view('livewire.category.category', [
            'categories' => ModelsCategory::paginate(10)
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
    
    public function editCategory($id)
    {
        $this->dispatch('edit-category', id: $id);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $category = ModelsCategory::findOrFail($id);
            $category->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            $this->dispatch('open-alert', status: 'error', message: 'Error :' . $th->getMessage());
        }

        $this->dispatch('open-alert', status: 'success', message: 'Category has been successfully deleted.');
    }
}
