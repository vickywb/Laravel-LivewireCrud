<?php

namespace App\Livewire\Component;

use Livewire\Component;
use Livewire\Attributes\On;

class Alert extends Component
{
    public $status, $message, $isAlert = false;

    #[On('open-alert')]
    public function openAlert($status, $message)
    {
        $this->isAlert = true;
        $this->status = $status;
        $this->message = $message;
    }

    public function closeAlert()
    {
        $this->isAlert = false;
        $this->status = '';
        $this->message = '';
    }
    public function render()
    {
        return view('livewire.component.alert');
    }
}
