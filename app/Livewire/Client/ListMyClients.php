<?php

namespace App\Livewire\Client;

use App\Models\AssignClassTeacher;
use Livewire\Component;

class ListMyClients extends Component
{
    public function render()
    {
        $client = auth()->user()->registrar;

        if (!$client) {
            return view('livewire.client.list-my-clients', ['teachers' => collect()]);
        }

        $teachers = AssignClassTeacher::with(['teacher.user', 'classNames', 'classPackage'])
            ->where('registrar_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.client.list-my-clients', compact('teachers'));
    }
}
