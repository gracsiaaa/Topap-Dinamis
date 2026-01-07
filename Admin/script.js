document.addEventListener('DOMContentLoaded', () => {
    
    const deleteButtons = document.querySelectorAll('.del-btn');
    
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const konfirmasi = confirm('⚠️ PERINGATAN!\n\nApakah Anda yakin ingin menghapus game ini?\nSemua produk/diamond di dalamnya juga akan ikut terhapus permanen.');
            if (!konfirmasi) {
                e.preventDefault();
            }
        });
    });

    const imgInput = document.getElementById('imgInput');
    const imgPreviewBox = document.querySelector('.img-preview-box img');

    if (imgInput) {
        imgInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (imgPreviewBox) {
                        imgPreviewBox.src = e.target.result;
                    } else {
                        const newPreview = document.createElement('img');
                        newPreview.src = e.target.result;
                        newPreview.className = 'img-preview';
                        newPreview.style.marginTop = '10px';
                        newPreview.style.width = '100%';
                        imgInput.parentNode.appendChild(newPreview);
                    }
                }
                
                reader.readAsDataURL(file);
            }
        });
    }

});