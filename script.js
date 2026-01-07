document.addEventListener('DOMContentLoaded', () => {

    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    };

    const searchInput = document.getElementById('search-input');
    const gameListContainer = document.getElementById('game-list-container');

    if (searchInput && gameListContainer) {
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();
            const allGames = gameListContainer.querySelectorAll('.game-card');

            allGames.forEach(game => {
                const title = game.querySelector('.game-title').textContent.toLowerCase();
                game.style.display = title.includes(query) ? 'block' : 'none';
            });
        });
        const searchBtn = document.querySelector('.search-bar button');
        if (searchBtn) searchBtn.addEventListener('click', (e) => e.preventDefault());
    }

    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        const nominalGrid = document.getElementById('nominal-grid');
        const priceDisplay = document.getElementById('total-price');

        nominalGrid.addEventListener('change', (e) => {
            if (e.target.name === 'nominal') {
                const price = parseInt(e.target.dataset.price, 10);
                priceDisplay.textContent = formatRupiah(price);
            }
        });

        orderForm.addEventListener('submit', (e) => {
            const userId = document.getElementById('user_id').value;
            const zoneInput = document.getElementById('zone_id'); 
            const zoneId = zoneInput ? zoneInput.value : '';

            const selectedNominal = document.querySelector('input[name="nominal"]:checked');
            const selectedPayment = document.querySelector('input[name="payment"]:checked');

            if (!userId) {
                alert('Harap isi ID / Username Anda!');
                e.preventDefault(); return;
            }

            if (zoneInput && !zoneId) {
                alert('Harap isi Zone ID / Server!');
                e.preventDefault(); return;
            }

            if (!selectedNominal || !selectedPayment) {
                alert('Harap pilih nominal dan metode pembayaran!');
                e.preventDefault(); return;
            }

            const fullId = zoneInput ? `${userId} (${zoneId})` : userId;

            const orderData = {
                userId: fullId,
                productName: selectedNominal.dataset.name,
                paymentName: selectedPayment.dataset.name,
                priceFormatted: formatRupiah(selectedNominal.dataset.price)
            };

            localStorage.setItem('currentOrder', JSON.stringify(orderData));
        });
    }

    const checkoutPage = document.getElementById('checkout-page');
    const paymentPage = document.getElementById('payment-page');

    if (checkoutPage || paymentPage) {
        const orderData = JSON.parse(localStorage.getItem('currentOrder'));

        if (!orderData) {
            alert('Data pesanan tidak ditemukan!');
            window.location.href = 'index.php';
            return;
        }

        const dataMap = {
            'summary-user-id': orderData.userId,
            'summary-product': orderData.productName,
            'summary-payment': orderData.paymentName,
            'summary-total-price': orderData.priceFormatted,
            'payment-method-title': orderData.paymentName,
            'summary-name': orderData.customerName,
            'summary-contact': orderData.customerContact
        };

        Object.keys(dataMap).forEach(id => {
            const el = document.getElementById(id);
            if (el && dataMap[id]) el.textContent = dataMap[id];
        });

        const checkoutForm = document.getElementById('checkout-form');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', (e) => {
                orderData.customerName = document.getElementById('full_name').value;
                orderData.customerContact = document.getElementById('contact').value;
                localStorage.setItem('currentOrder', JSON.stringify(orderData));
            });
        }
    }
});