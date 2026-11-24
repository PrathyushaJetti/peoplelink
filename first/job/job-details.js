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
        saveJobButton.addEventListener('click', function () {
            const key = 'peoplelink_saved_jobs';
            let saved = [];
            try { saved = JSON.parse(localStorage.getItem(key) || '[]'); } catch (e) {}
            const id = Number(details.id);
            const isSaved = saved.includes(id);
            if (isSaved) saved = saved.filter(function (item) { return item !== id; });
            else saved.push(id);
            try { localStorage.setItem(key, JSON.stringify(saved)); } catch (e) {}
            saveJobButton.classList.toggle('is-saved', !isSaved);
            saveJobButton.innerHTML = !isSaved
                ? '<i class="fa-solid fa-bookmark"></i> Saved'
                : '<i class="fa-regular fa-bookmark"></i> Save Job';
            if (shareFeedback) shareFeedback.textContent = !isSaved ? 'Job saved in this browser.' : 'Job removed from saved jobs.';
        });
        try {
            const saved = JSON.parse(localStorage.getItem('peoplelink_saved_jobs') || '[]');
            if (saved.includes(Number(details.id))) {
                saveJobButton.classList.add('is-saved');
                saveJobButton.innerHTML = '<i class="fa-solid fa-bookmark"></i> Saved';
            }
        } catch (e) {}
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
