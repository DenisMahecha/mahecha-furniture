<div class="settings-layout flex items-start gap-8 max-md:flex-col">
    <div class="settings-nav w-full pb-4 md:w-[220px]">
        <p class="settings-nav-label">Mipangilio</p>
        <flux:navlist>
            <flux:navlist.item icon="user-circle" href="{{ route('settings.profile') }}" wire:navigate>Wasifu</flux:navlist.item>
            <flux:navlist.item icon="lock-closed" href="{{ route('settings.password') }}" wire:navigate>Nenosiri</flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="settings-content flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
