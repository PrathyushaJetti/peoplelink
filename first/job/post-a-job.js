document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('postJobForm');
    if (!form) return;

    const communityFields = document.getElementById('communityFields');
    const globalNotice = document.getElementById('globalNotice');
    const communitySelect = document.getElementById('community_id');
    const communityNamePreview = document.getElementById('communityNamePreview');
    const visibilityCards = document.querySelectorAll('[data-visibility-card]');
    const methodWhatsapp = document.getElementById('methodWhatsapp');
    const methodEmail = document.getElementById('methodEmail');
    const whatsappField = document.getElementById('whatsappNumberField');
    const applicationEmailField = document.getElementById('applicationEmailField');
    const applicationEmail = document.getElementById('application_email');
    const whatsappNumber = document.getElementById('application_whatsapp');
    const logoInput = document.getElementById('company_logo');
    const logoPreview = document.getElementById('logoPreview');
    const logoFileName = document.getElementById('logoFileName');
    const previewModal = document.getElementById('previewModal');
    let selectedLogoData = '';

    function currentVisibility() {
        const selected = form.querySelector('input[name="visibility"]:checked');
        return selected ? selected.value : 'community';
    }

    function updateVisibility() {
        const visibility = currentVisibility();
        visibilityCards.forEach(function (card) {
            const radio = card.querySelector('input[type="radio"]');
            card.classList.toggle('active', !!radio && radio.checked);
        });
        if (communityFields) communityFields.hidden = visibility !== 'community';
        if (globalNotice) globalNotice.hidden = visibility !== 'global';
        if (communitySelect) communitySelect.required = visibility === 'community';
    }

    function updateCommunityPreview() {
        if (communityNamePreview && communitySelect) {
            communityNamePreview.textContent = communitySelect.value || 'Select a community';
        }
    }

    function updateApplicationMethods() {
        if (whatsappField) whatsappField.hidden = !methodWhatsapp.checked;
        if (applicationEmailField) applicationEmailField.hidden = !methodEmail.checked;
        if (whatsappNumber) whatsappNumber.required = methodWhatsapp.checked;
        if (applicationEmail) applicationEmail.required = methodEmail.checked;
    }

    form.querySelectorAll('input[name="visibility"]').forEach(function (radio) {
        radio.addEventListener('change', updateVisibility);
    });
    if (communitySelect) communitySelect.addEventListener('change', updateCommunityPreview);
    if (methodWhatsapp) methodWhatsapp.addEventListener('change', updateApplicationMethods);
    if (methodEmail) methodEmail.addEventListener('change', updateApplicationMethods);
    updateVisibility();
    updateCommunityPreview();
    updateApplicationMethods();

    if (logoInput) {
        logoInput.addEventListener('change', function () {
            const file = logoInput.files && logoInput.files[0];
            if (!file) {
                selectedLogoData = '';
                logoPreview.hidden = true;
                logoFileName.textContent = 'No logo selected';
                return;
            }
            const allowed = ['image/png', 'image/jpeg', 'image/webp'];
            if (!allowed.includes(file.type)) {
                alert('Please upload a PNG, JPG or WEBP logo.');
                logoInput.value = '';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                alert('Company logo must be 2 MB or less.');
                logoInput.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function (event) {
                selectedLogoData = event.target.result;
                logoPreview.src = selectedLogoData;
                logoPreview.hidden = false;
            };
            reader.readAsDataURL(file);
            logoFileName.textContent = file.name;
        });
    }

    const modalOpen = function () {
        if (!previewModal) return;
        updatePreview();
        previewModal.classList.add('is-open');
        previewModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        const close = previewModal.querySelector('.pj-modal-close');
        if (close) close.focus();
    };
    const modalClose = function () {
        if (!previewModal) return;
        previewModal.classList.remove('is-open');
        previewModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };
    const val = function (name, fallback) {
        const element = form.elements[name];
        return element && String(element.value).trim() ? String(element.value).trim() : (fallback || 'Not specified');
    };
    const updatePreview = function () {
        const set = function (id, value) {
            const element = document.getElementById(id);
            if (element) element.textContent = value;
        };
        set('previewVisibility', currentVisibility() === 'community' ? 'Community Job' : 'Global Job');
        set('previewJobTitle', val('job_title', 'Job Title'));
        set('previewCompany', val('company_name', 'Company Name'));
        set('previewLocation', val('job_location', 'Location'));
        set('previewType', val('employment_type', 'Employment Type'));
        set('previewMode', val('work_mode', 'Work Mode'));
        set('previewExperience', val('experience', 'Experience'));
        set('previewSummary', val('job_summary', 'Your job summary will appear here.'));
        set('previewResponsibilities', val('responsibilities', 'Your responsibilities will appear here.'));
        set('previewSkills', val('skills_required', 'Your required skills will appear here.'));
        set('previewCommunity', currentVisibility() === 'community' ? val('community_id', 'Select a community') : 'Global — visible across PeopleLink');
        const min = Number(val('salary_min', '0')) || 0;
        const max = Number(val('salary_max', '0')) || 0;
        let salary = 'Salary not disclosed';
        if (min && max) salary = '₹' + min.toLocaleString('en-IN') + ' – ₹' + max.toLocaleString('en-IN') + ' / month';
        else if (min) salary = 'From ₹' + min.toLocaleString('en-IN') + ' / month';
        else if (max) salary = 'Up to ₹' + max.toLocaleString('en-IN') + ' / month';
        set('previewSalary', salary);
        const mark = document.getElementById('previewLogoMark');
        if (mark) {
            if (selectedLogoData) mark.innerHTML = '<img src="' + selectedLogoData + '" alt="Company logo">';
            else mark.textContent = val('company_name', 'C').charAt(0).toUpperCase();
        }
    };

    const previewButton = document.getElementById('previewJob');
    if (previewButton) previewButton.addEventListener('click', function () {
        if (!form.reportValidity()) return;
        if (methodWhatsapp && methodEmail && !methodWhatsapp.checked && !methodEmail.checked) {
            alert('Select at least one application method.');
            return;
        }
        modalOpen();
    });

    if (previewModal) {
        previewModal.querySelectorAll('[data-close-preview]').forEach(function (button) {
            button.addEventListener('click', modalClose);
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && previewModal.classList.contains('is-open')) modalClose();
        });
    }

    const previewSubmit = document.getElementById('previewSubmit');
    if (previewSubmit) previewSubmit.addEventListener('click', function () {
        modalClose();
        const submitButton = form.querySelector('button[name="submit_job"]');
        if (submitButton) {
            // Request native form validation and submit the intended action.
            if (form.reportValidity()) form.requestSubmit(submitButton);
        }
    });

    form.addEventListener('submit', function (event) {
        const submitter = event.submitter;
        if (submitter && submitter.name === 'submit_job') {
            if (methodWhatsapp && methodEmail && !methodWhatsapp.checked && !methodEmail.checked) {
                event.preventDefault();
                alert('Select at least one application method.');
                return;
            }
            const min = Number(val('salary_min', '0')) || 0;
            const max = Number(val('salary_max', '0')) || 0;
            if (min && max && max < min) {
                event.preventDefault();
                alert('Maximum salary cannot be lower than minimum salary.');
                return;
            }
            const start = val('application_start', '');
            const end = val('application_end', '');
            if (start && end && end < start) {
                event.preventDefault();
                alert('Closing date cannot be earlier than the start date.');
            }
        }
    });
});
