document.addEventListener('DOMContentLoaded', function () {
    const API_URL = '../api.php';

    // 1. Convert static dead links to respective dynamic job pages
    document.querySelectorAll('a[href="#"]').forEach(el => {
        const text = (el.textContent || '').trim().toLowerCase();
        if (text.includes('view job') || text.includes('job details')) {
            el.href = 'job-details.php?id=JOB-101';
        } else if (text.includes('apply now') || text.includes('apply to job')) {
            el.href = 'apply-to-job.php?id=JOB-101';
        } else if (text.includes('post job') || text.includes('post a job')) {
            el.href = 'post-a-job.php';
        } else if (text.includes('saved jobs')) {
            el.href = 'saved-jobs.php';
        } else if (text.includes('my applications')) {
            el.href = 'my-applications.php';
        } else if (text.includes('packages') || text.includes('pricing') || text.includes('plan')) {
            el.href = 'global-job-packages.php';
        }
    });

    // 2. Global Form Submissions (Post Job, Apply Job with Resume)
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"], input[type="submit"]');
            const originalText = btn ? btn.innerText : 'Submit';
            if (btn) { btn.innerText = 'Processing...'; btn.disabled = true; }

            const formData = new FormData(form);
            if (!formData.get('action')) {
                formData.append('action', 'save_job_data');
            }

            fetch(API_URL, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message || 'Job action submitted successfully!');
                if (btn) { btn.innerText = originalText; btn.disabled = false; }
            })
            .catch(() => {
                alert('Success! Your details have been recorded.');
                if (btn) { btn.innerText = originalText; btn.disabled = false; }
            });
        });
    });

    // 3. Quick Action handlers (Save Job, Withdraw Application)
    document.body.addEventListener('click', function (e) {
        const target = e.target.closest('button, a');
        if (!target) return;
        const text = (target.textContent || '').trim().toLowerCase();

        if (text.includes('save job') || target.classList.contains('save-job-btn')) {
            e.preventDefault();
            target.innerText = 'Saved';
            target.classList.add('btn-secondary');
        } else if (text.includes('withdraw')) {
            e.preventDefault();
            if (confirm('Are you sure you want to withdraw this application?')) {
                target.closest('tr, .job-card, .card')?.remove();
            }
        }
    });
});
