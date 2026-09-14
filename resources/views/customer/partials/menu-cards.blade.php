@foreach ($menus as $menu)
    <div class="menu-card">

        <div class="menu-info">
            <h4>{{ $menu->name }}</h4>

            <span class="menu-category">
                {{ $menu->category->name }}
            </span>

            <div class="menu-price">
                Rp {{ number_format($menu->price, 0, ',', '.') }}
            </div>
        </div>

        <div class="quantity">
            <label>Jumlah</label>

            <input
                type="number"
                name="qty[{{ $menu->id }}]"
                value="0"
                min="0"
                max="99"
            >
        </div>

    </div>
@endforeach

<script>
    let currentPage = 1;

    document.getElementById('showMoreBtn')?.addEventListener('click', async function () {

        const button = this;

        button.disabled = true;
        button.textContent = 'Loading...';

        currentPage++;

        try {
            const response = await fetch(
                `{{ route('checkout.menus') }}?page=${currentPage}`
            );

            const data = await response.json();

            document.querySelector('.menu-grid')
                .insertAdjacentHTML('beforeend', data.html);

            if (!data.hasMore) {
                button.remove();
            } else {
                button.disabled = false;
                button.textContent = 'Show More';
            }

        } catch (error) {
            currentPage--;

            button.disabled = false;
            button.textContent = 'Show More';

            console.error(error);
        }
    });
</script>

<style>
    .show-more-wrapper {
    display: flex;
    justify-content: center;
    margin: 25px 0;
}

.show-more-btn {
    border: none;
    border-radius: 8px;
    padding: 11px 30px;
    background: #5a3828;
    color: white;
    font-size: 14px;
    cursor: pointer;
}

.show-more-btn:hover {
    opacity: .9;
}

.show-more-btn:disabled {
    opacity: .6;
    cursor: wait;
}
</style>