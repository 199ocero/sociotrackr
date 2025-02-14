<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">

        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">Log in to your account</flux:heading>
                <flux:subheading>Welcome back!</flux:subheading>
            </div>

            <div class="space-y-6">
                <flux:input wire:model="form.email" label="Email" type="email" placeholder="Your email address"
                    autofocus />

                <flux:field>
                    <div class="mb-3 flex justify-between">
                        <flux:label>Password</flux:label>
                        @if (Route::has('password.request'))
                            <flux:link href="{{ route('password.request') }}" variant="subtle" class="text-sm">Forgot
                                password?</flux:link>
                        @endif
                    </div>

                    <flux:input wire:model="form.password" type="password" placeholder="Your password" />

                    <flux:error name="form.password" />
                </flux:field>

                <flux:checkbox wire:model="form.remember" label="Remember me" />
            </div>

            <div class="space-y-2">
                <flux:button variant="primary" class="w-full" type="submit">Log in</flux:button>

                <flux:button href="{{ route('register') }}" variant="ghost" class="w-full">Sign up for a
                    new account
                </flux:button>
            </div>
        </flux:card>
    </form>
</div>
