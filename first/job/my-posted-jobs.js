document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('jobDetailsModal');
    const closeControls = document.querySelectorAll('[data-close-modal]');
    let lastFocused = null;

    function openModal(card) {
        if (!modal || !card) return;
        lastFocused = document.activeElement;
        const d = card.dataset;
        document.getElementById('modalJobTitle').textContent = d.title || 'Job title';
        document.getElementById('modalCompany').textContent = d.company || 'Company name';
        document.getElementById('modalVisibility').textContent = d.visibility || 'Job';
        document.getElementById('modalStatus').textContent = d.status || 'Status';
        document.getElementById('modalDescription').textContent = d.description || 'No description provided.';
        const details = [
            ['Location', d.location], ['Community', d.community || 'Not applicable'],
            ['Category', d.category], ['Employment Type', d.type], ['Salary', d.salary],
            ['Openings', d.openings], ['Posted Date', d.posted], ['Closing Date', d.closing]
        ];
        const grid = document.getElementById('modalDetailsGrid');
        grid.replaceChildren();
        details.forEach(function (item) {
            const box = document.createElement('div');
            box.className = 'mpj-detail';
            const label = document.createElement('small');
            label.textContent = item[0];
            const value = document.createElement('strong');
            value.textContent = item[1] || '—';
            box.append(label, value);
            grid.appendChild(box);
        });
        const appContainer = document.getElementById('modalApplications');
        appContainer.replaceChildren();
        [['Applications Received', d.applications], ['WhatsApp Enquiries', d.whatsapp], ['Email Applications', d.email]].forEach(function (item) {
            const box = document.createElement('div');
            const label = document.createElement('small'); label.textContent = item[0];
            const value = document.createElement('strong'); value.textContent = item[1] || '0';
            box.append(label, value); appContainer.appendChild(box);
        });
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        const closeButton = modal.querySelector('.mpj-modal-close');
        if (closeButton) closeButton.focus();
    }
    function closeModal() {
        if (!modal) return;
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        if (lastFocused && typeof lastFocused.focus === 'function') lastFocused.focus();
    }
    document.querySelectorAll('[data-view-job]').forEach(function (button) {
        button.addEventListener('click', function () { openModal(button.closest('[data-job-card]')); });
    });
    closeControls.forEach(function (button) { button.addEventListener('click', closeModal); });
    document.addEventListener('keydown', function (event) { if (event.key === 'Escape' && modal && modal.classList.contains('open')) closeModal(); });
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm(form.dataset.confirm || 'Continue with this action?')) event.preventDefault();
        });
    });
});
