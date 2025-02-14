<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">

    <flux:card class="space-y-6">
        <div>
            <flux:heading size="lg">Delete Account</flux:heading>
            <flux:subheading>Once your account is deleted, all of its resources and data will be permanently deleted.
            </flux:subheading>
        </div>

        <div>
            <flux:modal.trigger name="delete-account">
                <flux:button variant="danger">Delete Account</flux:button>
            </flux:modal.trigger>
        </div>
    </flux:card>

    <flux:modal name="delete-account" class="md:w-96 space-y-6">
        <div>
            <flux:heading size="lg">Are you sure you want to delete your account?</flux:heading>
            <flux:subheading>Once your account is deleted, all of its resources and data will be permanently deleted.
            </flux:subheading>
        </div>

        <form wire:submit="deleteUser" class="w-full space-y-6">

            <flux:input wire:model="password" label="Password" type="password" placeholder="Your password" autofocus />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="danger">Delete Account</flux:button>
            </div>

        </form>
    </flux:modal>
</section>
