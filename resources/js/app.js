import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // 1. AUTO SEARCH INPUT (Typing)
    const searchInputs = document.querySelectorAll('[data-auto-search]');
    
    searchInputs.forEach(input => {
        let timeout = null;
        
        // Pindahkan kursor ke akhir teks (untuk UX lebih baik saat reload)
        if (input.value) {
            const val = input.value;
            input.value = '';
            input.value = val;
            input.focus();
        }

        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const form = input.closest('form');
                if (form) {
                    form.submit();
                }
            }, 600); // Delay 600ms
        });
    });

    // 2. AUTO SUBMIT SELECT (Dropdown Change)
    const autoSubmitSelects = document.querySelectorAll('select[data-auto-submit]');
    
    autoSubmitSelects.forEach(select => {
        select.addEventListener('change', function() {
            const form = select.closest('form');
            if (form) {
                form.submit();
            }
        });
    });
});