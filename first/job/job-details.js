document.addEventListener('DOMContentLoaded', function () {
    const resumeInput = document.getElementById('resumeFile');
    const resumeName = document.getElementById('resumeFileName');
    const replaceButton = document.getElementById('replaceResume');
    const resumeForm = document.getElementById('resumeForm');
    const applyNowButton = document.getElementById('applyNowButton');
    const saveJobButton = document.getElementById('saveJobButton');
    const shareJobButton = document.getElementById('shareJobButton');
    const shareFeedback = document.getElementById('shareFeedback');
    const details = window.peopleLinkJobDetails || {};

    if (resumeInput && resumeName) {
        resumeInput.addEventListener('change', function () {
            const file = resumeInput.files && resumeInput.files[0];
            if (!file) {
                resumeName.textContent = 'No file selected';
                if (replaceButton) replaceButton.hidden = true;
                return;
            }
            const allowedExtensions = ['pdf', 'doc', 'docx'];
            const extension = file.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(extension)) {
                alert('Please choose a PDF, DOC or DOCX resume.');
                resumeInput.value = '';
                resumeName.textContent = 'No file selected';
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                alert('Resume size must be 5 MB or less.');
                resumeInput.value = '';
                resumeName.textContent = 'No file selected';
                return;
            }
            resumeName.textContent = file.name;
            if (replaceButton) replaceButton.hidden = false;
        });
    }

    if (replaceButton && resumeInput) {
        replaceButton.addEventListener('click', function () {
            resumeInput.click();
        });
    }

    if (resumeForm) {
        resumeForm.addEventListener('submit', function (event) {
            if (!resumeInput || !resumeInput.files || !resumeInput.files.length) {
                event.preventDefault();
                alert('Please select your resume before applying.');
                if (resumeInput) resumeInput.focus();
            }
        });
    }

    if (applyNowButton) {
        applyNowButton.addEventListener('click', function () {
            const applySection = document.getElementById('apply');
            if (applySection) applySection.scrollIntoView({behavior: 'smooth', block: 'start'});
        });
    }

    if (saveJobButton) {
        // Saved jobs are stored in the PeopleLink account (jobs_save_toggle), not in the browser
        saveJobButton.addEventListener('click', async function () {
            if (!window.PL || !PL.requireLogin()) return;
            saveJobButton.disabled = true;
            try {
                const r = await PL.post('jobs_save_toggle', { id: saveJobButton.dataset.jobId });
                if (!r.ok) { PL.toast(r.error || 'Could not save this job.', true); return; }
                saveJobButton.classList.toggle('is-saved', !!r.saved);
                saveJobButton.innerHTML = r.saved ? '<i class="fa-solid fa-bookmark"></i> Saved' : '<i class="fa-regular fa-bookmark"></i> Save Job';
                if (shareFeedback) shareFeedback.textContent = r.message || '';
            } catch (e) { /* redirected to login */ } finally { saveJobButton.disabled = false; }
        });
    }

    if (shareJobButton) {
        shareJobButton.addEventListener('click', async function () {
            const shareData = {title: document.title, text: 'View this job on PeopleLink: ' + (details.title || ''), url: window.location.href};
            try {
                if (navigator.share) {
                    await navigator.share(shareData);
                } else if (navigator.clipboard && navigator.clipboard.writeText) {
                    await navigator.clipboard.writeText(window.location.href);
                    if (shareFeedback) shareFeedback.textContent = 'Job link copied to clipboard.';
                } else {
                    window.prompt('Copy this job link:', window.location.href);
                }
            } catch (error) {
                if (error && error.name !== 'AbortError' && shareFeedback) shareFeedback.textContent = 'Unable to share automatically. Copy the page URL from your browser.';
            }
        });
    }
});
