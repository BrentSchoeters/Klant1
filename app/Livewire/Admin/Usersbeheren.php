<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\UserForm;
use App\Models\Gender;
use App\Models\Role;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Storage;

class Usersbeheren extends Component
{
    use WithPagination;

    public $newest = false;
    public $search;
    public $feedback="";
    public $admins = false;
    public $inactiveUsers = false;
    public $perPage = 15;
    public $loading = 'Laden ...';
    public $orderBy = 'firstname';
    public $id = null;

    public $firstname = "";
    public $surname = "";
    public $editFirstNameUser = ['id' => null, 'firstname' => null];
    public $editSurNameUser = ['id' => null, 'surname' => null];
    public $editEmailUser = ['id' => null, 'email' => null];
    public $orderAsc = true;
    public $showModal = false;
    public $selectedOption = 'namedesc';
    public UserForm $form;
    public $rol_id = null;
    public $update = false;


    public function newUser()
    {
        $this->update = false;
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }
    public function editUser (User $user)
    {
        $this->update = true;
        $this->resetErrorBag();
        $this->form->fill($user);
        $this->showModal = true;
    }
    public function updateUser(User $user)
    {
        $this->form->update($user);
        $this->update = false;
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De gebruiker <b><i>{$this->firstname} {$this->surname}</i></b> is geüpdatet",
            'icon' => 'success',
        ]);
    }
    public function createUser()
    {
        $this->form->create();
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De gebruiker <b><i>{$this->firstname} {$this->surname}</i></b> is toegevoegd!",
            'icon' => 'success',
        ]);
        $this->showModal = false;
    }

    public function updatedSelectedOption() {
        if ($this->selectedOption === '1'){
            $this->orderBy = 'firstname';
            $this->orderAsc = true;
        } elseif ($this->selectedOption === '2'){
            $this->orderBy = 'firstname';
            $this->orderAsc = false;
        }
        elseif ($this->selectedOption === '3'){
            $this->orderBy = 'surname';
            $this->orderAsc = true;
        }
        elseif ($this->selectedOption === '4'){
            $this->orderBy = 'surname';
            $this->orderAsc = false;
        }
        elseif ($this->selectedOption === '5'){
            $this->orderBy = 'email';
            $this->orderAsc = true;
        } elseif ($this->selectedOption === '6'){
            $this->orderBy = 'email';
            $this->orderAsc = false;
        }elseif ($this->selectedOption === '7'){
            $this->orderBy = 'role_id';
            $this->orderAsc = false;
        }elseif ($this->selectedOption === '8'){
            $this->orderBy = 'active';
            $this->orderAsc = true;
        }
    }

    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }
    public function switchActive(User $user) {
        if($user->active === 0)
            $user->update([
                'active' => 1
            ]);
        else
            $user->update([
                'active' => 0
            ]);
    }
    #[Layout('layouts.app', ['title' => 'UsersBeheren', 'description' => 'Users beheren',])]
    public function render()
    {
        $allGenders = Gender::all();
        $allRoles = Role::all();

        $usersBeheren = User::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->searchUser($this->search)
            ->paginate($this->perPage);

        if (!$this->inactiveUsers) {
            $usersBeheren->where('active', 1);
        }
        return view('livewire.admin.usersbeheren', compact('usersBeheren', 'allGenders', 'allRoles'));
    }
}
