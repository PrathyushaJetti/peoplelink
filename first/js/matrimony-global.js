/* PeopleLink matrimony API helper (talks to the real matrimoney api.php with CSRF) */
window.PL_API_URL = window.PL_API_URL || "/peoplelink/matrimoney/api.php";

window.plCsrf = window.plCsrf || (function () {
    let cached = null;
    return function () {
        if (cached) return Promise.resolve(cached);
        return fetch(window.PL_API_URL + "?action=session", { credentials: "same-origin" })
            .then(function (r) { return r.json(); })
            .then(function (s) { cached = s; return s; });
    };
})();

window.plProfileId = function (codeOrId) {
    codeOrId = String(codeOrId || "").trim();
    if (/^\d+$/.test(codeOrId)) return Promise.resolve(parseInt(codeOrId, 10));
    return fetch(window.PL_API_URL + "?action=profile&code=" + encodeURIComponent(codeOrId), { credentials: "same-origin" })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            if (res && res.ok && res.profile) return parseInt(res.profile.id, 10);
            throw new Error((res && res.error) || "Profile not found.");
        });
};

window.plPost = function (action, fields) {
    return window.plCsrf().then(function (s) {
        if (!s.logged_in) {
            return { ok: false, error: "Please login to continue.", login: true };
        }
        const fd = new FormData();
        fd.append("action", action);
        fd.append("csrf", s.csrf);
        Object.keys(fields || {}).forEach(function (k) { fd.append(k, fields[k]); });
        return fetch(window.PL_API_URL, { method: "POST", body: fd, credentials: "same-origin" })
            .then(function (r) { return r.json(); });
    });
};

window.plSendInterest = function (codeOrId, message) {
    return window.plProfileId(codeOrId).then(function (id) {
        return window.plPost("send_interest", { profile_id: id, message: message || "" });
    }).catch(function (e) { return { ok: false, error: e.message || "Could not send interest." }; });
};

window.plToggleSave = function (codeOrId) {
    return window.plProfileId(codeOrId).then(function (id) {
        return window.plPost("toggle_save", { profile_id: id });
    }).catch(function (e) { return { ok: false, error: e.message || "Could not save profile." }; });
};

document.addEventListener('DOMContentLoaded', function () {
    const API_URL = 'api.php';

    // 1. Standardize all View Profile links to matrimony-profile-details.php
    document.querySelectorAll('a, button').forEach(el => {
        const text = (el.textContent || '').trim().toLowerCase();
        if (text.includes('view profile') || text.includes('view full profile')) {
            if (el.tagName.toLowerCase() === 'a' && (!el.getAttribute('href') || el.getAttribute('href') === '#' || el.getAttribute('href').includes('matrimony-profile-detail.php'))) {
                var pid = el.getAttribute('data-id');
                if (pid) { el.href = 'matrimony-profile-details.php?id=' + encodeURIComponent(pid); }
            }
        }
    });

    // 2. Handle Express Interest & Save Profile Actions
    document.body.addEventListener('click', function (e) {
        const target = e.target.closest('button, a');
        if (!target) return;
        const text = (target.textContent || '').trim().toLowerCase();

        var codeOrId = target.getAttribute('data-id') || new URLSearchParams(window.location.search).get('id') || '';

        if (text.includes('express interest') || text.includes('send interest')) {
            e.preventDefault();
            if (!codeOrId) { alert('Open a profile first.'); return; }
            const originalText = target.innerText;
            target.innerText = 'Sending...';
            window.plSendInterest(codeOrId, '').then(function (res) {
                if (res.ok) {
                    target.innerText = 'Interest Sent';
                    target.disabled = true;
                } else {
                    target.innerText = originalText;
                    if (res.login) { window.location.href = 'login.php'; return; }
                }
                alert(res.ok ? (res.message || 'Interest sent.') : (res.error || 'Could not send interest.'));
            });
        } else if (text.includes('save profile') || text.includes('shortlist')) {
            e.preventDefault();
            if (!codeOrId) { alert('Open a profile first.'); return; }
            window.plToggleSave(codeOrId).then(function (res) {
                if (res.ok) { target.innerText = res.saved ? 'Saved' : 'Save Profile'; }
                else if (res.login) { window.location.href = 'login.php'; return; }
                alert(res.ok ? (res.message || 'Done.') : (res.error || 'Could not save profile.'));
            });
        }
    });

    // Support requests are handled by module-4/Frontend/pages/support.php (real ticket API).
});