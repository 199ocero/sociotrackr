<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <form wire:submit="updatePassword">

        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">Update Password</flux:heading>
                <flux:subheading>Ensure your account is using a long, random password to stay secure.</flux:subheading>
            </div>

            <div class="space-y-6">
                <flux:input wire:model="current_password" label="Current Password" type="password"
                    placeholder="Your current password" autofocus autocomplete="current-password" />
                <flux:input wire:model="password" label="New Password" type="password" placeholder="Your new password"
                    autocomplete="new-password" />
                <flux:input wire:model="password_confirmation" label="Confirm Password" type="password"
                    placeholder="Your new password confirmation" autocomplete="new-password" />
            </div>

            <div class="inline-flex gap-1 items-center">
                <flux:button variant="primary" class="w-full" type="submit">Save</flux:button>
                <x-action-message class="me-3" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </flux:card>
    </form>
</section>
