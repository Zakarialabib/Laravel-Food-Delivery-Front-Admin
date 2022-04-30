<?php

namespace App\Http\Livewire\Front;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Account extends Component
{
    // public User $user;

    public $customer, $l_name, $f_name, $mobile, $email, $address;

    public string $password = '';
   
    protected $listeners = [
        'submit',
    ];

    public function mount(User $customer)
    {
        // $customer =   User::find(Auth::user()->id);
        $this->f_name      = $customer->f_name;
        $this->l_name      = $customer->l_name;
        $this->address       = $customer->address;
        $this->mobile         = $customer->mobile;
        $this->email         = $customer->email;
        $this->password         = $customer->password;
        
    }

    protected $rules = [    
        'account.email'          => 'email',
        'account.f_name'        => 'required|string',
        'account.l_name'        => 'required|string',
        'account.address'       => 'max:255',
        'account.mobile'       => 'required|numeric|max:1O',
    ];

    public function submit()
    {

            $this->user = User::find(Auth::user()->id);
            
            $this->validate();
            
            if($this->password !== '')
            $this->user->password = bcrypt($this->password);

            $this->user->update();
           
    }

    public function render()
    {
        return view('livewire.front.account');
    }
}
