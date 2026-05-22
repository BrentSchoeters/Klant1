<?php

namespace App\Livewire\Trainer;

use App\Livewire\Forms\SpelerClothingForm;
use App\Livewire\Forms\spelerForm;
use App\Livewire\Forms\ParentPerChildForm;
use App\Models\Clothing;
use App\Models\ClothingPerPlayer;
use App\Models\ClothingSize;
use App\Models\Gender;
use App\Models\ParentPerChild;
use App\Models\Role;
use App\Models\Size;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;



class Spelersbeheren extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $newest = false;
    public $search;
    public $feedback = "";
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
    public $rol_id = null;
    public $update = false;

    public $where = ' ';

    public $test = false;
    public $secondParentInput = false;

    public spelerForm $form;
    public ParentPerChildForm $form1;
    public ParentPerChildForm $form2;
    public SpelerClothingForm $form3;
    public SpelerClothingForm $form4;
    public SpelerClothingForm $form5;

    public function newUser()
    {
        $this->update = false;
        $this->form->reset();
        $this->form1->reset();
        $this->form2->reset();
        $this->form3->reset();
        $this->form4->reset();
        $this->form5->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }
    public function createUser()
    {
        $this->form->create();
        $user = User::get()->last();
        $this->form1->setData($user->id);
        $this->form2->setData($user->id);

        $this->form1->create();

        if (!empty($this->form2->parent_id)) {
            $this->form2->create();
        }

        $this->form3->create(1);
        $this->form4->create(2);
        $this->form5->create(3);

        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De gebruiker <b><i>{$this->firstname} {$this->surname}</i></b> is toegevoegd!",
            'icon' => 'success',
        ]);
        $this->showModal = false;
    }
    public function editUser(User $user)
    {
        $this->form2->reset();

        $parentPerChild = ParentPerChild::where('child_id', $user->id)->get();
        if ($parentPerChild) {
            if ($parentPerChild->last() !== $parentPerChild->first()) {
                $this->form2->fill($parentPerChild->last());
            } else {
                $this->form2->setData($parentPerChild->first()->child_id);
            }
            $this->form1->fill($parentPerChild->first());
        }

        $playerClothing = ClothingPerPlayer::where('user_id', $user->id)->get();
        $this->form3->fill($playerClothing);
        $this->form4->fill($playerClothing);
        $this->form5->fill($playerClothing);

        $this->secondParentInput = false;
        if (empty($this->form2->parent_id)){
            $this->secondParentInput = true;
        } else {
            $this->secondParentInput = false;
        }

        $this->update = true;
        $this->resetErrorBag();
        $this->form->fill($user);
        $this->showModal = true;
    }

    public function updateUser(User $user)
    {
        $this->form->update($user);
        $this->updateParents($user->parent_per_children->first());
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De gebruiker <b><i>{$this->firstname} {$this->surname}</i></b> is geüdpatet",
            'icon' => 'success',
        ]);
    }

    public function updateParents(ParentPerChild $parentPerChild){
        $this->form1->update($parentPerChild);

        $secondParent = ParentPerChild::where('child_id', $parentPerChild->child_id)->whereNot('parent_id', $parentPerChild->parent_id);
        if (!empty($this->form2->parent_id)) {
            if ($secondParent->exists()) {
                $this->form2->update($secondParent->get()->first());
            } else {
                $this->form2->create();
            }
        } elseif ($this->secondParentInput === false) {
            $secondParent->get()->first()->delete();
        }
    }
    public function updatedSelectedOption()
    {
        if ($this->selectedOption === '1') {
            $this->orderBy = 'firstname';
            $this->orderAsc = true;
        } elseif ($this->selectedOption === '2') {
            $this->orderBy = 'firstname';
            $this->orderAsc = false;
        } elseif ($this->selectedOption === '3') {
            $this->orderBy = 'surname';
            $this->orderAsc = true;
        } elseif ($this->selectedOption === '4') {
            $this->orderBy = 'surname';
            $this->orderAsc = false;
        } elseif ($this->selectedOption === '5') {
            $this->orderBy = 'email';
            $this->orderAsc = true;
        } elseif ($this->selectedOption === '6') {
            $this->orderBy = 'email';
            $this->orderAsc = false;
        } elseif ($this->selectedOption === '7') {
            $this->orderBy = 'role_id';
            $this->orderAsc = false;
        } elseif ($this->selectedOption === '8') {
            $this->where = 'Gert';
            //$this->orderAsc = true;
        }
    }

    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

    public function switchActive(User $user)
    {
        if ($user->active === 0)
            $user->update([
                'active' => 1
            ]);
        else
            $user->update([
                'active' => 0
            ]);
    }

    public function switchPermissionPhotos(User $user)
    {
        if ($user->permission_photos === 0)
            $user->update([
                'permission_photos' => 1
            ]);
        else
            $user->update([
                'permission_photos' => 0
            ]);
    }

    public function findParents(User $user)
    {
        $parentPerChildRecords = ParentPerChild::where('child_id', $user->id)->get();
        $parents = [];

        foreach ($parentPerChildRecords as $record) {
            $parent = User::find($record->parent_id);
            if ($parent) {
                $parents[] = $parent;
            }
        }
        return $parents;
    }


    #[Layout('layouts.app', ['title' => 'SpelersBeheren', 'description' => 'Beheer de users',])]
    public function render()
    {
        $allGenders = Gender::all();
        $allRoles = Role::all();
        $parents = ParentPerChild::all();
        $parentsList = User::all();
        $sizes = Size::all();
        $clothingSizes1 = ClothingSize::where('clothing_id', 1)->get('size_id');
        $clothingSizes2 = ClothingSize::where('clothing_id', 2)->get('size_id');
        $clothingSizes3 = ClothingSize::where('clothing_id', 3)->get('size_id');

        $spelersBeheren = User::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->with('registrations')
            ->where('role_id', 3)
            ->searchUser($this->search)
            ->paginate($this->perPage);

        return view('livewire.spelersbeheren', compact('spelersBeheren', 'allGenders', 'allRoles', 'parents', 'parentsList', 'sizes', 'clothingSizes1', 'clothingSizes2','clothingSizes3'));
    }
}
