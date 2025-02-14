<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">

        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">Register for an account</flux:heading>
                <flux:subheading>Create a new account to start your journey.</flux:subheading>
            </div>

            <div class="space-y-6">
                <flux:input wire:model="name" label="Name" type="text" placeholder="Your full name" autofocus />
                <flux:input wire:model="email" label="Email" type="email" placeholder="Your email address" />
                <flux:input wire:model="password" label="Password" type="password" placeholder="Your password" />
                <flux:input wire:model="password_confirmation" label="Confirm Password" type="password"
                    placeholder="Your password confirmation" />
            </div>

            <div class="space-y-2">
                <flux:button variant="primary" class="w-full" type="submit">Create account</flux:button>

                <flux:button href="{{ route('login') }}" variant="ghost" class="w-full">Already have an
                    account?
                </flux:button>
            </div>
        </flux:card>
    </form>
</div>
