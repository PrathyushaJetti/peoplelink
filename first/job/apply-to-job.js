/* =====================================================
   PAGE 42 - APPLY TO JOB
   Front-end demo; connect the API before production use.
===================================================== */

document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const form = document.getElementById("ajApplicationForm");

    if (!form) return;

    const $ = (id) => document.getElementById(id);

    const uploadPanel = $("ajUploadPanel");
    const savedPanel = $("ajSavedResumePanel");
    const resumeInput = $("ajResume");
    const savedResume = $("ajSavedResume");
    const selectedResume = $("ajSelectedResume");
    const resumeFileName = $("ajResumeFileName");
    const replaceResume = $("ajReplaceResume");
    const removeResume = $("ajRemoveResume");

    const whatsappCheckbox = $("ajWhatsApp");
    const emailCheckbox = $("ajEmailMethod");
    const whatsappCard = $("ajWhatsAppCard");
    const emailCard = $("ajEmailCard");

    const submitButton = $("ajSubmitButton");
    const formError = $("ajFormError");
    const successOverlay = $("ajSuccessOverlay");
    const successMessage = $("ajSuccessMessage");
    const applicationReference = $("ajApplicationReference");
    const messageInput = $("ajMessage");
    const messageCount = $("ajMessageCount");

    let selectedFile = null;

    /*
     * DEMO JOB CONFIGURATION
     *
     * In production, load this data from your backend using
     * the job ID and the authenticated user's session.
     */

    const job = window.AJ_JOB || {
        id: "JOB-1001",
        title: "PHP Web Developer",
        company: "Deep Web Solution",
        location: "Rishikesh, Uttarakhand",
        type: "Full Time",
        visibility: "Community Job",
        closingDate: "31 Oct 2026",

        // Replace these with verified employer contact details.
        whatsappNumber: "",
        employerEmail: "",

        methods: {
            whatsapp: true,
            email: true
        }
    };

    /*
     * SAMPLE PROFILE
     *
     * Replace this example with profile data returned by
     * your authenticated backend. Do not trust client-side
     * profile values as authoritative.
     */

    const demoProfile = window.AJ_PROFILE || {
        fullName: "Your Name",
        mobile: "",
        email: "",
        qualification: "",
        experience: "",
        currentLocation: ""
    };

    // -----------------------------------------------
    // 1. Populate the job summary
    // -----------------------------------------------

    function populateJob() {
        $("ajJobTitle").textContent = job.title;
        $("ajCompanyName").textContent = job.company;
        $("ajLocation").textContent = job.location;
        $("ajJobType").textContent = job.type;
        $("ajJobVisibility").textContent = job.visibility;
        $("ajClosingDate").textContent = job.closingDate;

        document.title = "Apply to " + job.title + " | PeopleLink";

        // Populate employer-enabled application methods.
        configureMethod(
            whatsappCheckbox,
            whatsappCard,
            job.methods.whatsapp
        );

        configureMethod(
            emailCheckbox,
            emailCard,
            job.methods.email
        );

        if (!job.methods.whatsapp && !job.methods.email) {
            showError(
                "This job currently has no enabled application methods."
            );
            submitButton.disabled = true;
        }
    }

    function configureMethod(checkbox, card, enabled) {
        checkbox.checked = Boolean(enabled);
        checkbox.disabled = !enabled;
        card.classList.toggle("is-disabled", !enabled);

        const status = card.querySelector(".aj-method-status");

        if (status) {
            status.innerHTML = enabled
                ? '<i class="fa-solid fa-check-circle"></i> Enabled'
                : '<i class="fa-solid fa-ban"></i> Not available';
        }
    }

    // -----------------------------------------------
    // 2. Autofill available profile information
    // -----------------------------------------------

    function populateProfile(profile) {
        const fields = {
            ajFullName: profile.fullName,
            ajMobile: profile.mobile,
            ajEmail: profile.email,
            ajQualification: profile.qualification,
            ajCurrentLocation: profile.currentLocation
        };

        Object.entries(fields).forEach(([id, value]) => {
            const field = $(id);

            if (field && value) {
                field.value = value;
            }
        });

        if (profile.experience) {
            $("ajExperience").value = profile.experience;
        }
    }

    /*
     * DEMO:
     * This only inserts sample profile data.
     *
     * Production example:
     *
     * fetch("/api/profile", { credentials: "same-origin" })
     *   .then(response => {
     *       if (!response.ok) throw new Error("Profile unavailable");
     *       return response.json();
     *   })
     *   .then(profile => populateProfile(profile))
     *   .catch(error => console.error(error));
     *
     * Implement authentication, authorization and CSRF
     * protection as appropriate for your backend.
     */

    populateJob();
    populateProfile(demoProfile);

    // -----------------------------------------------
    // 3. Resume selection
    // -----------------------------------------------

    function getResumeMode() {
        const selected = form.querySelector(
            'input[name="resumeMode"]:checked'
        );

        return selected ? selected.value : "upload";
    }

    function updateResumeMode() {
        const mode = getResumeMode();

        uploadPanel.hidden = mode !== "upload";
        savedPanel.hidden = mode !== "saved";

        if (mode === "saved") {
            clearSelectedFile();
        }

        hideError();
    }

    function clearSelectedFile() {
        selectedFile = null;
        resumeInput.value = "";
        selectedResume.hidden = true;
        resumeFileName.textContent = "";
    }

    function displaySelectedFile(file) {
        selectedFile = file;
        resumeFileName.textContent = file.name;
        selectedResume.hidden = false;
    }

    function validateResumeFile(file) {
        if (!file) return "Please select a resume file.";

        const allowedExtensions = /\.(pdf|doc|docx)$/i;
        const maxSize = 5 * 1024 * 1024;

        if (!allowedExtensions.test(file.name)) {
            return "Please upload a PDF, DOC or DOCX resume.";
        }

        if (file.size > maxSize) {
            return "Your resume must be 5 MB or smaller.";
        }

        if (file.size === 0) {
            return "The selected resume file is empty.";
        }

        return "";
    }

    resumeInput.addEventListener("change", () => {
        const file = resumeInput.files[0];

        if (!file) {
            clearSelectedFile();
            return;
        }

        const error = validateResumeFile(file);

        if (error) {
            clearSelectedFile();
            showError(error);
            resumeInput.focus();
            return;
        }

        hideError();
        displaySelectedFile(file);
    });

    replaceResume.addEventListener("click", () => {
        resumeInput.click();
    });

    removeResume.addEventListener("click", () => {
        clearSelectedFile();
        hideError();
    });

    form.querySelectorAll('input[name="resumeMode"]')
        .forEach((radio) => {
            radio.addEventListener("change", updateResumeMode);
        });

    savedResume.addEventListener("change", hideError);

    updateResumeMode();

    // -----------------------------------------------
    // 4. Optional message counter
    // -----------------------------------------------

    function updateMessageCount() {
        messageCount.textContent = messageInput.value.length;
    }

    messageInput.addEventListener("input", updateMessageCount);

    // -----------------------------------------------
    // 5. Application method selection
    // -----------------------------------------------

    function getSelectedMethods() {
        const methods = [];

        if (whatsappCheckbox.checked && !whatsappCheckbox.disabled) {
            methods.push("whatsapp");
        }

        if (emailCheckbox.checked && !emailCheckbox.disabled) {
            methods.push("email");
        }

        return methods;
    }

    [whatsappCheckbox, emailCheckbox].forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            checkbox.closest(".aj-method-card")
                .classList.toggle("is-selected", checkbox.checked);

            hideError();
        });
    });

    // -----------------------------------------------
    // 6. Validation
    // -----------------------------------------------

    function showError(message) {
        formError.textContent = message;
        formError.hidden = false;

        formError.scrollIntoView({
            behavior: "smooth",
            block: "center"
        });
    }

    function hideError() {
        formError.textContent = "";
        formError.hidden = true;
    }

    function validateApplication() {
        hideError();

        const requiredFields = [
            ["ajFullName", "Please enter your full name."],
            ["ajMobile", "Please enter your mobile number."],
            ["ajEmail", "Please enter your email address."],
            ["ajQualification", "Please enter your qualification."],
            ["ajExperience", "Please select your experience."],
            ["ajCurrentLocation", "Please enter your current location."]
        ];

        for (const [id, message] of requiredFields) {
            const field = $(id);
            const value = field.value.trim();

            if (!value) {
                showError(message);
                field.focus();
                return false;
            }

            if (!field.checkValidity()) {
                showError("Please enter a valid " +
                    field.labels[0].textContent.replace("*", "").trim() +
                    ".");
                field.focus();
                return false;
            }
        }

        const mobile = $("ajMobile").value.trim();

        if (!/^[+()\d\s-]{7,20}$/.test(mobile)) {
            showError("Please enter a valid mobile number.");
            $("ajMobile").focus();
            return false;
        }

        const email = $("ajEmail").value.trim();

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showError("Please enter a valid email address.");
            $("ajEmail").focus();
            return false;
        }

        if (getResumeMode() === "upload") {
            if (!selectedFile) {
                showError("Please upload your resume.");
                resumeInput.focus();
                return false;
            }

            const resumeError = validateResumeFile(selectedFile);

            if (resumeError) {
                showError(resumeError);
                return false;
            }
        } else if (!savedResume.value) {
            showError("Please choose a previously uploaded resume.");
            savedResume.focus();
            return false;
        }

        if (getSelectedMethods().length === 0) {
            showError("Please select at least one application method.");
            whatsappCheckbox.focus();
            return false;
        }

        if (!job.methods.whatsapp && !job.methods.email) {
            showError("No application methods are enabled for this job.");
            return false;
        }

        if (!$("ajConfirm").checked) {
            showError("Please confirm that your information is correct.");
            $("ajConfirm").focus();
            return false;
        }

        return true;
    }

    // -----------------------------------------------
    // 7. Build application payload
    // -----------------------------------------------

    function buildApplicationPayload() {
        return {
            jobId: job.id,

            applicant: {
                fullName: $("ajFullName").value.trim(),
                mobile: $("ajMobile").value.trim(),
                email: $("ajEmail").value.trim(),
                qualification: $("ajQualification").value.trim(),
                experience: $("ajExperience").value,
                currentLocation: $("ajCurrentLocation").value.trim()
            },

            resume: {
                mode: getResumeMode(),
                savedResumeId: getResumeMode() === "saved"
                    ? savedResume.value
                    : null,
                file: selectedFile
            },

            methods: getSelectedMethods(),

            message: messageInput.value.trim(),

            informationConfirmed: $("ajConfirm").checked
        };
    }

    // -----------------------------------------------
    // 8. Demo success confirmation
    // -----------------------------------------------

    function showSuccess(payload, reference) {
        const selectedNames = payload.methods.map((method) => {
            return method === "whatsapp" ? "WhatsApp" : "Email";
        });

        successMessage.textContent =
            "Your application details passed the front-end checks. " +
            "Selected method" +
            (selectedNames.length > 1 ? "s: " : ": ") +
            selectedNames.join(" and ") +
            ". In this demo, the application has not been saved or sent.";

        applicationReference.textContent = reference;
        successOverlay.hidden = false;

        document.body.style.overflow = "hidden";

        const dialog = successOverlay.querySelector('[role="dialog"]');
        const primaryLink = successOverlay.querySelector(
            ".aj-success-primary"
        );

        if (dialog) {
            dialog.setAttribute("tabindex", "-1");
            dialog.focus();
        }

        // Keep the payload available for debugging during development.
        // Remove sensitive logging before production.
        void payload;
        void primaryLink;
    }

    function closeSuccess() {
        successOverlay.hidden = true;
        document.body.style.overflow = "";
    }

    // Close the dialog by clicking the backdrop.
    successOverlay.addEventListener("click", (event) => {
        if (event.target === successOverlay) {
            closeSuccess();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && !successOverlay.hidden) {
            closeSuccess();
        }
    });

    // -----------------------------------------------
    // 9. Form submission
    // -----------------------------------------------

    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        if (!validateApplication()) return;

        const payload = buildApplicationPayload();

        submitButton.disabled = true;
        submitButton.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin"></i> ' +
            'Preparing application...';

        try {
            /*
             * DEMO MODE ONLY
             *
             * No network request is made here.
             *
             * For production, replace this block with a POST
             * to your authenticated backend, sending FormData
             * so the resume file can be uploaded.
             *
             * The backend must:
             * 1. Verify the user and job.
             * 2. Check the closing date and application rules.
             * 3. Verify the actual saved resume belongs to the user.
             * 4. Validate the uploaded file on the server.
             * 5. Store the application and return its real ID.
             * 6. Deliver email or create the configured WhatsApp flow.
             */

            // Real submission: the backend action jobs_apply (same as the mobile app)
            const fd = new FormData();
            fd.append("csrf", (window.PL_WEB || {}).csrf || "");
            fd.append("job_id", job.id);
            fd.append("method", "in_app");
            fd.append("name", payload.applicant.fullName);
            fd.append("phone", payload.applicant.mobile);
            fd.append("email", payload.applicant.email);
            fd.append("total_experience", payload.applicant.experience);
            fd.append("current_location", payload.applicant.currentLocation);
            fd.append("cover_letter", [payload.applicant.qualification ? "Qualification: " + payload.applicant.qualification : "", payload.message].filter(Boolean).join("\n\n"));
            if (payload.resume.mode === "upload" && payload.resume.file) { fd.append("resume", payload.resume.file); fd.append("save_resume", "1"); }
            else fd.append("use_saved_resume", payload.resume.mode === "saved" ? "1" : "0");
            const res = await fetch(((window.PL_WEB || {}).api || "/peoplelink/matrimoney/api.php") + "?action=jobs_apply", { method: "POST", body: fd, credentials: "same-origin" });
            const r = await res.json();
            if (!r.ok) {
                if (r.code === "AUTH_REQUIRED") { window.location.href = (window.PL_WEB || {}).loginUrl; return; }
                showError(r.error || "We couldn't process your application.");
                return;
            }
            showSuccess(payload, (r.application && r.application.application_code) || ("#" + ((r.application && r.application.id) || "")));

        } catch (error) {
            console.error("Application submission failed:", error);

            showError(
                "We couldn't process your application. " +
                "Please try again."
            );

        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML =
                'Submit Application ' +
                '<i class="fa-solid fa-arrow-right"></i>';
        }
    });

    // -----------------------------------------------
    // 10. Optional job data from URL query parameters
    // -----------------------------------------------

    /*
     * Example:
     * apply-to-job.php?jobId=JOB-1001
     *
     * In production, fetch the job using jobId from the
     * backend. Do not trust job details supplied in the URL.
     */

    const params = new URLSearchParams(window.location.search);
    const requestedJobId = params.get("jobId");

    if (requestedJobId) {
        /*
         * TODO:
         * Fetch the requested job from your API and replace
         * the demo job data with the server response.
         */
    }
});