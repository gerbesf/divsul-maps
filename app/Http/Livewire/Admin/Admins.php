<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Admins extends Component
{

    // Form Inputs
    public $form_nickname;
    public $form_name;
    public $form_mail;
    public $form_password;
    public $form_level;

    public $form = false;
    public $action = false;

    // Entity Update
    public $id_entity;


    public function mount(){
      #  $this->viewEntity(1);
    }

    public function viewEntity( $id ){
        $this->form = true;
        $this->action = 'modify';
        $entity = User::where('id',$id)->first();
       # dd($entity);
        $this->id_entity = $entity->id;
        $this->form_name = $entity->name;
        $this->form_mail = $entity->email;
        $this->form_nickname = $entity->nickname;
        $this->form_level = $entity->level;
    }

    public function updateEntity(){

        try {
            User::where('id',$this->id_entity)->update([
                'name' => $this->form_name,
                'email' => $this->form_mail,
                'nickname' => $this->form_nickname,
                'level' => $this->form_level,
            ]);
            $this->backTable();
        }catch (\Exception $exception){
            session()->flash('message', $exception->getMessage());
        }

    }

    public function createForm(){
        $this->form = true;
        $this->action = 'create';
        $this->form_level = 'M';
    }

    public function createEntity(){
        if($this->form_name && $this->form_mail && $this->form_nickname && $this->form_level) {
            $count = User::where('email',$this->form_mail)->count();
            if($count==0){
                User::create([
                    'nickname' => $this->form_nickname,
                    'email' => $this->form_mail,
                    'name' => $this->form_name,
                    'password' => Hash::make($this->form_password),
                    'level' => $this->form_level,
                ]);
                $this->backTable();
            }else{
                session()->flash('message', 'This email is already registered');
            }
        }
    }

    public function removeAdmin( $id ){
        User::where('id',$id)->delete();
    }

    public function backTable(){
        $this->form=false;
        $this->action=false;
        $this->id_entity = null;
        $this->form_name = null;
        $this->form_mail  = null;
        $this->form_nickname  = null;
        $this->form_level  = null;
    }

    public function render()
    {

        $Users = User::get();

        return view('livewire.admin.admins',[
            'users' => $Users
        ]);
    }
   /* public function render()
    {
        return view('livewire.admins');
    }*/
}
