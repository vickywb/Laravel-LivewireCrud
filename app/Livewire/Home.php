<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{

    use WithPagination;

    public function render()
    {
        return view('livewire.home',
        [
            'articles' => Article::with('user')
                ->latest()
                ->take(3)
                ->get()
        ])
        ->title('Home');
    }
}
