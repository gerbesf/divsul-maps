<div>
    <div class="text-2xl w-full text-center text-neutral-content border border-gray-700 0 py-5 rounded" wire:poll="checkValid">
        <div wire:init="checkValid">
        {{ str_replace(' from now','',\Carbon\Carbon::parse( $entity->expires_at)->diffForHumans()) }}
        </div>
    </div>
</div>
