<x-app-layout>
    <flux:card>
        <!-- Main Heading -->
        <flux:heading size="xl" level="1">
            Welcome to Idea Toolbox, {{ auth()->user()->name }}! 🚀
        </flux:heading>

        <!-- Subheading -->
        <flux:subheading size="lg">
            Your ai-powered generator hub for creative ideas, smart solutions, and instant inspiration 🧠✨
        </flux:subheading>
    </flux:card>
</x-app-layout>
