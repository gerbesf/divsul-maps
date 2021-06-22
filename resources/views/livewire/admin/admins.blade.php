<div>

    @if(!$form)
        <div class="py-2">
            <button class="btn  btn-sm btn-primary  mb-3" wire:click="createForm">Add new </button>
        </div>
    @endif
    @if($form)

        <div class="py-2">
            <button class="btn  btn-sm btn-primary mb-3" wire:click="backTable">Back</button>
        </div>

        <div class=" bg-neutral p-6 rounded shadow">

            @if($action=="modify")
                <div class="h4 text-primary pb-3 mb-3 border-b border-neutral">Modify Admin</div>
            @else
                <div class="h4 text-primary  pb-3 mb-3 border-b border-neutral">Create a new Admin</div>
            @endif



            <div class="">

                <div class="">
                    <x-label for="Name" :value="__('Name')" />
                    <x-input id="form_name" class="block mt-1 w-full text-white"
                             type="text"
                             wire:model="form_name"
                             name="form_name"
                             required/>
                </div>

                <div class="mt-4">
                    <x-label for="Name" :value="__('Email')" />
                    <x-input id="form_mail" class="block mt-1 w-full text-white"
                             type="text"
                             wire:model="form_mail"
                             name="form_mail"
                             required/>
                </div>

                <div class="mt-4">
                    <x-label for="Name" :value="__('Nickname')" />
                    <x-input id="form_nickname" class="block mt-1 w-full text-white"
                             type="text"
                             name="form_nickname"
                             wire:model="form_nickname"
                             required/>
                </div>

                @if($action!="modify")

                    <div class="mt-4">
                        <x-label for="form_level" :value="__('Password')" />
                        <x-input id="form_nickname" class="block mt-1 w-full text-white"
                                 type="password"
                                 name="form_password"
                                 wire:model="form_password"
                                 required/>
                    </div>

                @endif
                <div class="mt-4">
                    <x-label for="form_level" :value="__('Level')" />
                    <select wire:model="form_level" class="input input-bordered block mt-1 w-full text-white">
                        <option value="M">Master Admin</option>
                        <option value="A">Admin</option>
                    </select>
                </div>

            </div>
            <div class=" m-auto">
            <div class="mt-5 mb-3  ">

                @if($action=="modify")
                    <button wire:click="updateEntity" class="btn btn-primary btn-sm  ">Update User</button>
                @else
                    <button wire:click="createEntity" class="btn btn-primary btn-sm ">Create</button>
                @endif

            </div>
            </div>
        </div>


            @if (session()->has('message'))
                <div class="alert alert-warning rounded-full mt-3 text-center">
                    {{ session('message') }}
                </div>
            @endif
    @else


        <div class=" w-100 ">
            <div class="overflow-x-auto">
                <table class="table table-compact w-full">
                    <thead class="text-gray-600">
                    <tr>
                        <th>Nickname</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="text-neutral-content">
                            <td class="font-bold  ">{{ $user->nickname }}</td>
                            <td> <span class="font-bold ">{{ $user->email }}</span></td>
                            <td>
                                @if($user->level=="M")
                                    <span class="text-green-400">Master</span>
                                @else
                                    <span class="text-red-500">Admin</span>
                                @endif
                            </td>
                            <td>

                                <button type="button" wire:click="viewEntity({{ $user->id }})" class="btn btn-primary btn-xs " >
                                    <span class="fa fa-edit"></span> Modify
                                </button>

                                <button type="button" wire:click="removeAdmin({{ $user->id }})" class="btn btn-danger bg-red-900 btn-xs  float-right" >
                                    <span class="fa fa-trash"></span> Destroy
                                </button>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endif
</div>
