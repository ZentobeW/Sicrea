import './bootstrap';

const initEventSelection = (root = document) => {
    const master = root.querySelector('#select-all-events');
    if (!master || master.dataset.checkboxInit === 'true') return;

    const getCheckboxes = () => Array.from(root.querySelectorAll('.event-checkbox'));
    const sync = (checked) => getCheckboxes().forEach((cb) => { cb.checked = checked; });

    master.addEventListener('change', (event) => sync(event.target.checked));
    sync(master.checked ?? true);

    master.dataset.checkboxInit = 'true';
};

const initAutoSubmitSelects = (root = document) => {
    const selects = root.querySelectorAll('select[data-auto-submit]');
    selects.forEach((select) => {
        if (select.dataset.autoSubmitBound === 'true') return;
        select.dataset.autoSubmitBound = 'true';

        select.addEventListener('change', () => {
            const form = select.closest('form');
            if (!form) return;
            submitForm(form);
        });
    });
};

const performAjaxLoad = (url, target, options = {}) => {
    if (!target) {
        window.location.href = url;
        return;
    }

    target.setAttribute('data-loading', 'true');

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            Accept: 'text/html',
        },
    })
        .then((response) => {
            if (!response.ok) throw new Error('Request failed');
            return response.text();
        })
        .then((html) => {
            target.innerHTML = html;
            rebindInteractive(target);

            if (options.updateHistory) {
                window.history.replaceState({}, '', url);
            }
        })
        .catch(() => {
            window.location.href = url;
        })
        .finally(() => {
            target.removeAttribute('data-loading');
        });
};

const submitForm = (form) => {
    const targetSelector = form.dataset.ajaxTarget;

    if (targetSelector) {
        const target = document.querySelector(targetSelector);
        const method = (form.method || 'GET').toLowerCase();

        if (!target || method !== 'get') {
            form.submit();
            return;
        }

        const url = new URL(form.action || window.location.href, window.location.origin);
        url.search = new URLSearchParams(new FormData(form)).toString();

        performAjaxLoad(url.toString(), target, { updateHistory: true });
        return;
    }

    form.submit();
};

const initAutoSearchInputs = (root = document) => {
    const searchInputs = root.querySelectorAll('[data-auto-search]');

    searchInputs.forEach((input) => {
        if (input.dataset.autoSearchBound === 'true') return;
        input.dataset.autoSearchBound = 'true';

        let timeout = null;

        if (input.value) {
            const val = input.value;
            input.value = '';
            input.value = val;
            input.focus();
        }

        input.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const form = input.closest('form');
                if (!form) return;
                submitForm(form);
            }, 500);
        });
    });
};

const initAjaxPagination = (root = document) => {
    const containers = root.querySelectorAll('[data-ajax-pagination]');

    containers.forEach((container) => {
        if (container.dataset.ajaxPaginationBound === 'true') return;
        container.dataset.ajaxPaginationBound = 'true';

        container.addEventListener('click', (event) => {
            const link = event.target.closest('.pagination-links a');
            if (!link) return;

            event.preventDefault();
            performAjaxLoad(link.href, container, { updateHistory: true });
        });
    });
};

const rebindInteractive = (root = document) => {
    initAutoSearchInputs(root);
    initAutoSubmitSelects(root);
    initEventSelection(root);
    initAjaxPagination(root);
};

document.addEventListener('DOMContentLoaded', () => {
    initAutoSearchInputs();
    rebindInteractive();
});
