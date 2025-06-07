const API_BASE = "https://api.unlockthemove.com/api";

function setToken(token) {
    document.cookie = `unlock_token=${token}; path=/`;
}
function getToken() {
    const match = document.cookie.match(/(^| )unlock_token=([^;]+)/);
    return match ? match[2] : null;
}
function hideSignupForm() {
    const form = document.querySelector("#unlock-signup-form");
    if (form) {
        form.style.display = "none";
    }
}

/** ─── LOGIN ───────────────────────────────────────────── **/
function doLogin(e) {
    e.preventDefault(); // blocca il comportamento predefinito del form
    const email = document.querySelector("#unlock-login-email")?.value;
    const password = document.querySelector("#unlock-login-password")?.value;
    const msgDiv = document.querySelector("#unlock-login-message");
    const wrapper = document.querySelector(".unlock-login-wrapper");
    // 'redirectUrl' is for after successful login
    const redirectUrl = wrapper?.dataset.redirectUrl || "/"; // Default to '/' if not set

    if (!email || !password) {
        if (msgDiv) msgDiv.innerText = "Email e password obbligatorie.";
        return;
    }

    fetch(`${API_BASE}/login`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({ email, password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.token) {
            setToken(data.token);
            if (msgDiv) msgDiv.innerText = "Login avvenuto con successo.";

            // Redirect se configurato e non vuoto
            if (redirectUrl && redirectUrl.trim() !== '') {
                window.location.href = redirectUrl;
                return;
            }

            // Altrimenti, carica pacchetti e profilo
            loadPackagesList();
            loadUserProfile();
        } else {
            if (msgDiv) msgDiv.innerText = "Login fallito.";
        }
    })
    .catch(err => {
        console.error(err);
        if (msgDiv) msgDiv.innerText = "Errore di connessione.";
    });
}

/** ─── SIGNUP ─────────────────────────────────────────── **/
function doSignup(e) {
    e.preventDefault(); // blocca il submit predefinito
    const name     = document.querySelector("#unlock-signup-name")?.value;
    const surname  = document.querySelector("#unlock-signup-surname")?.value;
    const email    = document.querySelector("#unlock-signup-email")?.value;
    const password = document.querySelector("#unlock-signup-password")?.value;
    const confirm  = document.querySelector("#unlock-signup-password-confirm")?.value;
    const msgDiv   = document.querySelector("#unlock-signup-message");
    const wrapper  = document.querySelector(".unlock-signup-wrapper");
    // 'redirectUrl' is for after successful signup
    const redirectUrl = wrapper?.dataset.redirectUrl || "/"; // Default to '/' if not set

    if (!name || !surname || !email || !password || !confirm) {
        if (msgDiv) msgDiv.innerText = "Tutti i campi sono obbligatori.";
        return;
    }
    if (password !== confirm) {
        if (msgDiv) msgDiv.innerText = "Le password non coincidono.";
        return;
    }

    const payload = {
        name: name,
        surname: surname,
        email: email,
        password: password,
        password_confirmation: confirm
    };

    fetch(`${API_BASE}/sign-up`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (data.token) {
            setToken(data.token);
            if (msgDiv) msgDiv.innerText = "Registrazione avvenuta con successo.";

            // Redirect se configurato e non vuoto
            if (redirectUrl && redirectUrl.trim() !== '') {
                window.location.href = redirectUrl;
                return;
            }

            hideSignupForm();
            loadUserProfile();
        } else {
            let errorMsg = "Registrazione fallita.";
            if (data.errors) {
                const errs = [];
                for (const key in data.errors) {
                    errs.push(data.errors[key].join(" "));
                }
                errorMsg = errs.join(" ");
            }
            if (msgDiv) msgDiv.innerText = errorMsg;
        }
    })
    .catch(err => {
        console.error(err);
        if (msgDiv) msgDiv.innerText = "Errore di connessione.";
    });
}

/** ─── LISTA PACCHETTI ───────────────────────────────────── **/
function loadPackagesList() {
    const container = document.querySelector("#unlock-packages-list");
    if (!container) return;

    const token = getToken();
    container.innerHTML = "<p>Caricamento pacchetti…</p>";

    fetch(`${API_BASE}/stripe/packages`, {
        headers: token
            ? { "Authorization": `Bearer ${token}`, "Accept": "application/json" }
            : { "Accept": "application/json" }
    })
    .then(res => res.json())
    .then(response => {
        container.innerHTML = "";
        const packages = response.data; // Access the nested array
        if (Array.isArray(packages) && packages.length) {
            packages.forEach(pkg => {
                const card = document.createElement("div");
                card.classList.add("unlock-package-card");
                card.setAttribute("data-id", pkg.id);
                const imageUrl = pkg.image_url && pkg.image_url.trim() !== '' ? pkg.image_url : 'https://via.placeholder.com/150';

                card.innerHTML = `
                    <img src="${imageUrl}" alt="${pkg.name}" class="unlock-package-image" style="width:100%;max-width:150px;height:auto;margin-bottom:10px;">
                    <h4 class="unlock-package-name">${pkg.name}</h4>
                    <p class="unlock-package-desc">${pkg.description || ''}</p>
                    <p class="unlock-package-price">${pkg.price}</p>
                    <ul>
                        ${pkg.features.map(f => `<li>${f}</li>`).join("")}
                    </ul>
                    <button class="unlock-buy-btn" data-id="${pkg.id}">Acquista</button>
                `;
                container.appendChild(card);
            });
        } else {
            container.innerHTML = "<p>Nessun pacchetto disponibile.</p>";
        }
    })
    .catch(err => {
        console.error(err);
        container.innerHTML = "<p>Errore nel caricamento dei pacchetti.</p>";
    });
}

/** ─── SINGOLO PACCHETTO ─────────────────────────────────── **/
function loadSinglePackage(pkgId) {
    const container = document.querySelector(`#unlock-single-package-${pkgId}`);
    if (!container) return;

    const token = getToken();
    container.innerHTML = "<p>Caricamento dettagli…</p>";

    fetch(`${API_BASE}/stripe/packages/${pkgId}`, {
        headers: token
            ? { "Authorization": `Bearer ${token}`, "Accept": "application/json" }
            : { "Accept": "application/json" }
    })
    .then(res => res.json())
    .then(response => {
        const pkg = response.data || response; // Handle potential nesting for single package
        const imageUrl = pkg.image_url && pkg.image_url.trim() !== '' ? pkg.image_url : 'https://via.placeholder.com/150';
        container.innerHTML = `
            <img src="${imageUrl}" alt="${pkg.name}" class="unlock-package-image" style="width:100%;max-width:150px;height:auto;margin-bottom:10px;">
            <h4 class="unlock-package-name">${pkg.name}</h4>
            <p class="unlock-package-desc">${pkg.description || ''}</p>
            <p class="unlock-package-price">${pkg.price}</p>
            <ul>
                ${pkg.features.map(f => `<li>${f}</li>`).join("")}
            </ul>
            <button class="unlock-buy-btn" data-id="${pkg.id}">Acquista</button>
        `;
    })
    .catch(err => {
        console.error(err);
        container.innerHTML = "<p>Errore nel caricamento del pacchetto.</p>";
    });
}

/** ─── ACQUISTA PACCHETTO ─────────────────────────────────── **/
function doPurchase(pkgId) {
    const token = getToken();
    if (!token) {
        alert("Devi essere loggato.");
        return;
    }

    fetch(`${API_BASE}/purchase-package`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`,
            "Accept": "application/json"
        },
        body: JSON.stringify({ package_id: parseInt(pkgId) })
    })
    .then(res => res.json())
    .then(() => {
        alert("Pacchetto acquistato con successo.");
    })
    .catch(err => {
        console.error(err);
        alert("Errore durante l'acquisto.");
    });
}

/** ─── PROFILE ─────────────────────────────────────────── **/
function loadUserProfile() {
    const wrapper = document.querySelector(".unlock-profile-wrapper");
    if (!wrapper) return;

    const redirectUrl = wrapper.dataset.redirectUrl || "";
    const contentDiv  = document.querySelector("#unlock-profile-content");
    const token       = getToken();

    // Se non loggato e c’è redirect, reindirizza subito
    if (!token) {
        if (redirectUrl) {
            window.location.href = redirectUrl;
        } else if (contentDiv) {
            contentDiv.innerHTML = "<p>Devi effettuare il login.</p>";
        }
        return;
    }

    // Carica /user
    fetch(`${API_BASE}/user`, {
        headers: {
            "Authorization": `Bearer ${token}`,
            "Accept": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        let html = "";

        const settings = JSON.parse(document.querySelector('.unlock-profile-settings')?.dataset.settings || '{}');

        // Helper function to generate a field item
        const createField = (label, value, labelKey, valueKey, sectionKey, showFlag) => {
            if (settings[showFlag] === 'yes') {
                const customLabel = settings[labelKey] || label;
                return `<div class="unlock-profile-field unlock-profile-field-${sectionKey.toLowerCase().replace('_', '-')}">
                          <span class="unlock-profile-field-label">${customLabel}:</span> 
                          <span class="unlock-profile-field-value">${value || '-'}</span>
                        </div>`;
            }
            return '';
        };

        // Header con avatar e nome
        html += `<div class="unlock-profile-header">`;
        if (settings.show_avatar === 'yes' && data.user.avatarUrl) {
            html += `<img src="${data.user.avatarUrl}" alt="Avatar" class="unlock-profile-avatar">`;
        }
        html += `<div class="unlock-profile-name-details">`;
        if (settings.show_fullname === 'yes'){
            html += `<h2 class="unlock-profile-fullname">${data.user.fullName}</h2>`;
        }
        if (settings.show_join_date === 'yes'){
            const joinDateLabel = settings.label_join_date || 'Joined';
            html += `<p class="unlock-profile-joindate"><span class="unlock-profile-field-label">${joinDateLabel}:</span> <span class="unlock-profile-field-value">${data.user.joinDate}</span></p>`;
        }
        html += `</div></div>`; // .unlock-profile-name-details, .unlock-profile-header

        // Informazioni Utente Section
        let userInfoHtml = '';
        userInfoHtml += createField(settings.label_email || 'Email', data.user.email, 'label_email', 'value_email', 'email', 'show_email');
        userInfoHtml += createField(settings.label_phone || 'Phone', data.user.phone, 'label_phone', 'value_phone', 'phone', 'show_phone');
        userInfoHtml += createField(settings.label_job_title || 'Job Title', data.user.jobTitle, 'label_job_title', 'value_job_title', 'job_title', 'show_job_title');
        userInfoHtml += createField(settings.label_location || 'Location', data.location, 'label_location', 'value_location', 'location', 'show_location');
        userInfoHtml += createField(settings.label_company || 'Company', data.company, 'label_company', 'value_company', 'company', 'show_company');
        
        if (settings.show_roles === 'yes' && data.user.roles && data.user.roles.length > 0) {
            const rolesLabel = settings.label_roles || 'Roles';
            userInfoHtml += `<div class="unlock-profile-field unlock-profile-field-roles">
                               <span class="unlock-profile-field-label">${rolesLabel}:</span> 
                               <ul class="unlock-profile-field-value unlock-profile-roles-list">
                                 ${data.user.roles.map(r => `<li>${r.name}</li>`).join("")}
                               </ul>
                             </div>`;
        }

        if (userInfoHtml) {
            html += `<div class="unlock-profile-section unlock-profile-user-info">
                        <h4 class="unlock-section-title">${settings.label_user_info_heading || 'User Information'}</h4>
                        ${userInfoHtml}
                     </div>`;
        }

        // Biografia e Link Section
        let bioHtml = '';
        if (settings.show_biography === 'yes') {
            const bioLabel = settings.label_biography || 'Biography';
            bioHtml += `<div class="unlock-profile-field unlock-profile-field-biography">
                          <span class="unlock-profile-field-label">${bioLabel}:</span> 
                          <p class="unlock-profile-field-value">${data.biography || "-"}</p>
                        </div>`;
        }
        if (settings.show_link === 'yes' && data.link) {
            const linkLabel = settings.label_link || 'Link';
            bioHtml += `<div class="unlock-profile-field unlock-profile-field-link">
                          <span class="unlock-profile-field-label">${linkLabel}:</span> 
                          <a class="unlock-profile-field-value" href="${data.link}" target="_blank">${data.link}</a>
                        </div>`;
        }
        if (bioHtml) {
             html += `<div class="unlock-profile-section unlock-profile-bio-link">
                        <h4 class="unlock-section-title">${settings.label_bio_link_heading || 'Details'}</h4>
                        ${bioHtml}
                      </div>`;
        }

        // Sottoscrizione Section
        if (settings.show_subscription === 'yes') {
            html += `<div class="unlock-profile-section unlock-profile-subscription">
                        <h4 class="unlock-section-title">${settings.label_subscription_heading || 'Subscription'}</h4>`;
            if (data.subscription.plan && data.subscription.plan !== "none") {
                html += createField(settings.label_subscription_plan || 'Plan', data.subscription.plan, 'label_subscription_plan', 'value_subscription_plan', 'subscription_plan', 'show_subscription'); // Assuming show_subscription controls the whole section
                html += createField(settings.label_subscription_renewal || 'Renewal Date', data.subscription.renewalDate, 'label_subscription_renewal', 'value_subscription_renewal', 'subscription_renewal', 'show_subscription');
                if (data.subscription.features && data.subscription.features.length > 0) {
                     html += `<div class="unlock-profile-field unlock-profile-field-subscription-features">
                                <span class="unlock-profile-field-label">${settings.label_subscription_features || 'Features'}:</span>
                                <ul class="unlock-profile-field-value unlock-profile-features-list">
                                  ${data.subscription.features.map(f => `<li>${f}</li>`).join("")}
                                </ul>
                              </div>`;
                }
            } else {
                html += `<p class="unlock-profile-field-value">${settings.label_no_subscription || 'No active subscription.'}</p>`;
            }
            html += `</div>`;
        }

        // Metodi di Pagamento Section
        if (settings.show_payment_methods === 'yes') {
            html += `<div class="unlock-profile-section unlock-profile-payment-methods">
                        <h4 class="unlock-section-title">${settings.label_payment_methods_heading || 'Payment Methods'}</h4>`;
            if (data.paymentMethods && data.paymentMethods.length) {
                html += `<ul class="unlock-profile-field-value unlock-profile-payment-list">`;
                data.paymentMethods.forEach(pm => {
                    const isDefault = (data.paymentMethod && pm.id === data.paymentMethod.id) ? " (Default)" : "";
                    html += `<li>${pm.brand || pm.type || "–"} ending in ${pm.last4 || "-"}${isDefault}</li>`;
                });
                html += `</ul>`;
            } else {
                html += `<p class="unlock-profile-field-value">${settings.label_no_payment_methods || 'No payment methods registered.'}</p>`;
            }
            html += `</div>`;
        }

        // Nazionalità e Genere Section
        let natGenderHtml = '';
        if (settings.show_nationality === 'yes') {
             natGenderHtml += createField(settings.label_nationality || 'Nationality', `${data.nationality?.name || "-"} (${data.nationality?.code || "-"}) ${data.nationality?.flagEmoji || ""}`, 'label_nationality', 'value_nationality', 'nationality', 'show_nationality');
             natGenderHtml += createField(settings.label_phone_code || 'Phone Code', data.nationality?.phoneCode || "-", 'label_phone_code', 'value_phone_code', 'phone_code', 'show_nationality'); // Assuming show_nationality controls this too
        }
        if (settings.show_gender === 'yes') {
            natGenderHtml += createField(settings.label_gender || 'Gender', data.gender?.name || "-", 'label_gender', 'value_gender', 'gender', 'show_gender');
        }
        if (natGenderHtml) {
            html += `<div class="unlock-profile-section unlock-profile-nat-gender">
                        <h4 class="unlock-section-title">${settings.label_nat_gender_heading || 'Demographics'}</h4>
                        ${natGenderHtml}
                     </div>`;
        }

        // Credits Section
        if (settings.show_credits === 'yes') {
            html += `<div class="unlock-profile-section unlock-profile-credits">
                        <h4 class="unlock-section-title">${settings.label_credits_heading || 'Credits'}</h4>
                        ${createField(settings.label_credits || 'Credits', data.credits || 0, 'label_credits', 'value_credits', 'credits', 'show_credits')}
                     </div>`;
        }


        if (contentDiv) {
            contentDiv.innerHTML = html;
        }
    })
    .catch(err => {
        console.error(err);
        if (contentDiv) {
            contentDiv.innerHTML = "<p>Errore nel caricamento del profilo.</p>";
        }
    });
}

/** ─── SETUP EVENT LISTENERS ─────────────────────────────────────────────────┐ **/
function setupUnlockWidgets() {
    const token = getToken();

    // ───── REDIRECT SE GIÁ LOGGATO SULLA PAGINA DI LOGIN ─────
    const loginWrapper = document.querySelector(".unlock-login-wrapper");
    if (loginWrapper && token) {
        const redirectUrlIfLoggedIn = loginWrapper.dataset.redirectUrlIfLoggedIn || "/"; // Default to '/' if not set
        if (redirectUrlIfLoggedIn && redirectUrlIfLoggedIn.trim() !== '') {
            window.location.href = redirectUrlIfLoggedIn;
            return; // Stop further processing if redirected
        }
        // Fallback: hide form if no specific redirect for logged-in users, though redirect is preferred
        const loginFormEl = document.querySelector("#unlock-login-form");
        if (loginFormEl) loginFormEl.style.display = "none";
    }

    // ───── REDIRECT SE GIÁ LOGGATO SULLA PAGINA DI SIGNUP ─────
    const signupWrapper = document.querySelector(".unlock-signup-wrapper");
    if (signupWrapper && token) {
        const redirectUrlIfLoggedIn = signupWrapper.dataset.redirectUrlIfLoggedIn || "/"; // Default to '/' if not set
        if (redirectUrlIfLoggedIn && redirectUrlIfLoggedIn.trim() !== '') {
            window.location.href = redirectUrlIfLoggedIn;
            return; // Stop further processing if redirected
        }
        // Fallback: hide form if no specific redirect for logged-in users
        hideSignupForm();
    }

    // ───── LOGIN ─────────────────────────────────────────────
    const loginForm = document.querySelector("#unlock-login-form");
    if (loginForm) {
        loginForm.addEventListener("submit", doLogin);
    }

    // ───── SIGNUP ───────────────────────────────────────────
    const signupForm = document.querySelector("#unlock-signup-form");
    if (signupForm) {
        signupForm.addEventListener("submit", doSignup);
    }

    // ───── LISTA PACCHETTI ─────────────────────────────────────
    if (document.querySelector("#unlock-packages-list")) {
        loadPackagesList();
    }

    // ───── SINGOLO PACCHETTO ───────────────────────────────────
    document.querySelectorAll("[id^='unlock-single-package-']").forEach(div => {
        const pkgId = div.getAttribute("data-package-id");
        if (pkgId) {
            loadSinglePackage(pkgId);
        }
    });

    // ───── ACQUISTA PACCHETTO ───────────────────────────────────
    document.addEventListener("click", function(e) {
        if (e.target.matches(".unlock-buy-btn")) {
            const pkgId = e.target.getAttribute("data-id");
            doPurchase(pkgId);
        }
    });

    // ───── PROFILE ───────────────────────────────────────────
    if (document.querySelector(".unlock-profile-wrapper")) {
        loadUserProfile();
    }
}

document.addEventListener("DOMContentLoaded", setupUnlockWidgets);
/** ─────────────────────────────────────────────────────────────────────────────────────┘ **/
