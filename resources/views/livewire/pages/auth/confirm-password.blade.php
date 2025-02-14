<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (
            !Auth::guard('web')->validate([
                'email' => Auth::user()->email,
                'password' => $this->password,
            ])
        ) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="confirmPassword">

        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">Confirm your password</flux:heading>
                <flux:subheading>This is a secure area of the application. Please confirm your password before
                    continuing.</flux:subheading>
            </div>

            <flux:input wire:model="password" label="Password" type="password" placeholder="Your password" autofocus />

            <flux:button variant="primary" class="w-full" type="submit">Confirm</flux:button>
        </flux:card>
    </form>
</div>
