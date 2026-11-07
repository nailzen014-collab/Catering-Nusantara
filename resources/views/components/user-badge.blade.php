@props(['user'])

@php
    $isAdmin = $user->role === 'admin';
    $initial = mb_strtoupper(mb_substr($user->name, 0, 1));
@endphp

<a href="{{ route('profile.edit') }}"
    {{ $attributes->merge([
        'class' =>
            'group inline-flex items-center gap-2.5 rounded-full border border-ink/10 bg-paper/70 py-1 pl-1 pr-3 transition-colors hover:border-ink/30 hover:bg-paper',
    ]) }}
    aria-label="Profil {{ $user->name }} — {{ $isAdmin ? 'admin' : 'pelanggan' }}">
    <span
        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full font-display text-sm font-semibold {{ $isAdmin ? 'bg-clay text-cream' : 'bg-ink text-cream' }}">
        {{ $initial }}
    </span>

    <span class="min-w-0 leading-tight">
        <span class="block max-w-[9rem] truncate text-[12px] font-semibold text-ink">{{ $user->name }}</span>
        <span
            class="mt-0.5 flex items-center gap-1 text-[9px] font-semibold uppercase tracking-[0.16em] {{ $isAdmin ? 'text-clay' : 'text-muted' }}">
            <span class="inline-block h-1 w-1 rounded-full {{ $isAdmin ? 'bg-clay' : 'bg-leaf' }}" aria-hidden="true"></span>
            {{ $isAdmin ? 'Admin' : 'Pelanggan' }}
        </span>
    </span>
</a>
