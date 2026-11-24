document.addEventListener('DOMContentLoaded', function () {
    const sortSelect = document.getElementById('sortJobs');
    const filterForm = document.getElementById('filterForm');

    if (sortSelect && filterForm) {
        sortSelect.addEventListener('change', function () {
            let input = filterForm.querySelector('input[name="sort"]');
            if (!input) {
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'sort';
                filterForm.appendChild(input);
            }
            input.value = sortSelect.value;
            filterForm.submit();
        });
    }

    document.querySelectorAll('.save-job').forEach(function (button) {
        button.addEventListener('click', function () {
            const saved = button.classList.toggle('is-saved');
            button.innerHTML = saved
                ? '<i class="fa-solid fa-bookmark"></i><span>Saved</span>'
                : '<i class="fa-regular fa-bookmark"></i><span>Save Job</span>';
            button.setAttribute('aria-pressed', saved ? 'true' : 'false');
            // Demo only: connect this action to your authenticated save-job PHP endpoint.
        });
    });

    const loadButton = document.getElementById('loadMoreJobs');
    if (loadButton && Array.isArray(window.peopleLinkJobResults)) {
        let currentIndex = 0;
        const batchSize = 4;
        loadButton.addEventListener('click', function () {
            const list = document.getElementById('jobList');
            const remaining = window.peopleLinkJobResults.slice(currentIndex, currentIndex + batchSize);
            remaining.forEach(function (job) {
                const card = document.createElement('article');
                card.className = 'job-card';
                const isCommunity = job.scope === 'community';
                const salary = job.salary_min || job.salary_max
                    ? '₹' + Number(job.salary_min).toLocaleString('en-IN') + ' – ₹' + Number(job.salary_max).toLocaleString('en-IN') + ' / month'
                    : 'Salary not disclosed';
                const posted = new Date(job.posted + 'T00:00:00').toLocaleDateString('en-IN', {day:'2-digit',month:'short',year:'numeric'});
                const safe = function (value) {
                    return String(value == null ? '' : value).replace(/[&<>"']/g, function (char) {
                        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char];
                    });
                };
                card.innerHTML = `
                    <div class="job-card-top">
                        <div class="company-mark">${safe(String(job.company).charAt(0).toUpperCase())}</div>
                        <div class="job-main">
                            <div class="job-tags"><span class="job-type-tag">${isCommunity ? 'Community Job' : 'Global Job'}</span>${isCommunity && job.community ? `<span class="community-tag">${safe(job.community)} Community</span>` : ''}</div>
                            <h3>${safe(job.title)}</h3><p class="company-name">${safe(job.company)}</p>
                        </div>
                        <button type="button" class="save-job" data-job-id="${Number(job.id)}" aria-label="Save ${safe(job.title)}"><i class="fa-regular fa-bookmark"></i><span>Save Job</span></button>
                    </div>
                    <div class="job-meta">
                        <span><i class="fa-solid fa-location-dot"></i>${safe(job.location)}</span>
                        <span><i class="fa-solid fa-briefcase"></i>${safe(job.experience)}</span>
                        <span><i class="fa-solid fa-graduation-cap"></i>${safe(job.qualification)}</span>
                        <span><i class="fa-solid fa-clock"></i>${safe(job.job_type)}</span>
                        <span><i class="fa-solid fa-laptop"></i>${safe(job.work_mode)}</span>
                    </div>
                    <div class="job-card-bottom"><div class="salary"><i class="fa-solid fa-indian-rupee-sign"></i><strong>${safe(salary)}</strong><small>Posted ${safe(posted)}</small></div>
                    <div class="job-actions"><a class="btn btn-outline" href="job-details.php?id=${Number(job.id)}">View Details <i class="fa-solid fa-arrow-right"></i></a><a class="btn btn-primary" href="job-details.php?id=${Number(job.id)}#apply">Apply Now</a></div></div>`;
                list.appendChild(card);
            });
            currentIndex += remaining.length;
            list.querySelectorAll('.save-job').forEach(function (button) {
                if (button.dataset.bound === '1') return;
                button.dataset.bound = '1';
                button.addEventListener('click', function () {
                    const saved = button.classList.toggle('is-saved');
                    button.innerHTML = saved ? '<i class="fa-solid fa-bookmark"></i><span>Saved</span>' : '<i class="fa-regular fa-bookmark"></i><span>Save Job</span>';
                    button.setAttribute('aria-pressed', saved ? 'true' : 'false');
                });
            });
            if (currentIndex >= window.peopleLinkJobResults.length) loadButton.remove();
        });
    }
});
