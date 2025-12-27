document.addEventListener('DOMContentLoaded', () => {

    /**
     * ==========================================================
     * 1. UTILITIES & GLOBAL FUNCTIONS
     * ==========================================================
     */

    // Fungsi untuk memformat angka ke Rupiah
    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    };

    /**
     * ==========================================================
     * 2. FITUR SEARCH (index.php)
     * ==========================================================
     */
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

        // Mencegah reload jika tombol cari diklik
        const searchBtn = document.querySelector('.search-bar button');
        if (searchBtn) searchBtn.addEventListener('click', (e) => e.preventDefault());
    }

    /**
     * ==========================================================
     * 3. HALAMAN PRODUK (ml.php, dll)
     * ==========================================================
     */
    const orderForm = document.getElementById('order-form');
    // Di dalam script.js
    if (orderForm) {
        orderForm.addEventListener('submit', (e) => {
            // AMBIL DATA UNTUK VALIDASI
            const userId = document.getElementById('user_id').value;
            const selectedNominal = document.querySelector('input[name="nominal"]:checked');
            const selectedPayment = document.querySelector('input[name="payment"]:checked');

            // VALIDASI SEDERHANA
            if (!userId || !selectedNominal || !selectedPayment) {
                e.preventDefault(); // Hentikan submit HANYA jika data tidak lengkap
                alert('Harap lengkapi semua data!');
                return;
            }

            // SIMPAN KE LOCALSTORAGE (Opsional, jika Anda masih butuh data di sisi client)
            const orderData = {
                userId: userId,
                productName: selectedNominal.dataset.name,
                priceFormatted: formatRupiah(selectedNominal.dataset.price)
                // ... tambahkan data lain jika perlu
            };
            localStorage.setItem('currentOrder', JSON.stringify(orderData));

            // JANGAN panggil e.preventDefault() di sini agar form lanjut mengirim data ke payment.php
        });
    }
    if (orderForm) {
        const nominalGrid = document.getElementById('nominal-grid');
        const priceDisplay = document.getElementById('total-price');

        // Update harga saat pilihan nominal berubah
        nominalGrid.addEventListener('change', (e) => {
            if (e.target.name === 'nominal') {
                const price = parseInt(e.target.dataset.price, 10);
                priceDisplay.textContent = formatRupiah(price);
            }
        });

        // Handle Submit Form Produk
        orderForm.addEventListener('submit', (e) => {
            // Jika Anda ingin data disimpan ke database via PHP, 
            // biarkan form submit secara normal ke checkout.php.
            // Kode di bawah ini berguna jika Anda masih ingin memakai localStorage.

            const selectedNominal = document.querySelector('input[name="nominal"]:checked');
            const selectedPayment = document.querySelector('input[name="payment"]:checked');
            const userId = document.getElementById('user_id').value;
            const zoneId = document.getElementById('zone_id').value;

            if (!selectedNominal || !selectedPayment) {
                e.preventDefault();
                alert('Harap pilih nominal dan metode pembayaran!');
                return;
            }

            const orderData = {
                userId: `${userId} (${zoneId})`,
                productName: selectedNominal.dataset.name,
                paymentName: selectedPayment.dataset.name,
                priceFormatted: formatRupiah(selectedNominal.dataset.price)
            };

            localStorage.setItem('currentOrder', JSON.stringify(orderData));

            // Catatan: Jika form memiliki action="checkout.php", 
            // e.preventDefault() tidak perlu dipanggil agar PHP bisa menerima data POST.
        });
    }

    /**
     * ==========================================================
     * 4. HALAMAN CHECKOUT & PEMBAYARAN
     * ==========================================================
     */
    const checkoutPage = document.getElementById('checkout-page');
    const paymentPage = document.getElementById('payment-page');

    // Logika Pengisian Data di Halaman Checkout/Pembayaran
    if (checkoutPage || paymentPage) {
        const orderData = JSON.parse(localStorage.getItem('currentOrder'));

        if (!orderData) {
            alert('Data pesanan tidak ditemukan!');
            window.location.href = 'index.php';
            return;
        }

        // Mapping ID elemen ke data yang sesuai
        const dataMap = {
            'summary-user-id': orderData.userId,
            'summary-product': orderData.productName,
            'summary-payment': orderData.paymentName,
            'summary-total-price': orderData.priceFormatted,
            'payment-method-title': orderData.paymentName,
            'summary-name': orderData.customerName,
            'summary-contact': orderData.customerContact
        };

        // Isi otomatis elemen yang ada di halaman tersebut
        Object.keys(dataMap).forEach(id => {
            const el = document.getElementById(id);
            if (el && dataMap[id]) el.textContent = dataMap[id];
        });

        // Handle form tambahan di checkout-page (Data Diri)
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