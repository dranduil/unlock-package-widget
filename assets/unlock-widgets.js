const API_BASE = "https://api.flexa.life/api";

function setToken(token) {
    document.cookie = `unlock_token=${token}; path=/`;
}
function getToken() {
    const match = document.cookie.match(/(^| )unlock_token=([^;]+)/);
    return match ? match[2] : null;
}

/** ───────────── LOGIN ───────────── **/
function doLogin() {
    const email = document.querySelector("#unlock-login-email")?.value;
    const password = document.querySelector("#unlock-login-password")?.value;
    const msgDiv = document.querySelector("#unlock-login-message");

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
            // Eventuali callback: ricarica lista pacchetti e profilo
            loadPackagesList();
        } else {
            if (msgDiv) msgDiv.innerText = "Login fallito.";
        }
    })
    .catch(err => {
        console.error(err);
        if (msgDiv) msgDiv.innerText = "Errore di connessione.";
    });
}

// ─── SIGNUP ───────────────────────────────────────────
function doSignup() {
    const name     = document.querySelector("#unlock-signup-name")?.value;
    const surname  = document.querySelector("#unlock-signup-surname")?.value;
    const email    = document.querySelector("#unlock-signup-email")?.value;
    const password = document.querySelector("#unlock-signup-password")?.value;
    const confirm  = document.querySelector("#unlock-signup-password-confirm")?.value;
    const msgDiv   = document.querySelector("#unlock-signup-message");
    const wrapper  = document.querySelector(".unlock-signup-wrapper");

    if (!name || !surname || !email || !password || !confirm) {
        if (msgDiv) msgDiv.innerText = "Tutti i campi sono obbligatori.";
        return;
    }
    if (password !== confirm) {
        if (msgDiv) msgDiv.innerText = "Le password non coincidono.";
        return;
    }

    // Payload corrispondente alle tue regole di validazione
    const payload = {
        name:     name,
        surname:  surname,
        email:    email,
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

            // Se esiste redirect URL, reindirizza
            if (wrapper && wrapper.dataset.redirectUrl) {
                window.location.href = wrapper.dataset.redirectUrl;
                return;
            }

            // Altrimenti nascondi il form
            hideSignupForm();
        } else {
            // Potrebbe venire un errore di validazione
            let errorMsg = "Registrazione fallita.";
            if (data.errors) {
                // Unisci messaggi di errore
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

/** ───────────── LISTA PACCHETTI ───────────── **/
function loadPackagesList() {
    const container = document.querySelector("#unlock-packages-list");
    if (!container) return;

    const token = getToken();
    container.innerHTML = "<p>Caricamento pacchetti…</p>";

    fetch(`${API_BASE}/packages`, {
        headers: token
            ? { "Authorization": `Bearer ${token}`, "Accept": "application/json" }
            : { "Accept": "application/json" }
    })
    .then(res => res.json())
    .then(data => {
        container.innerHTML = "";
        if (Array.isArray(data) && data.length) {
            data.forEach(pkg => {
                const card = document.createElement("div");
                card.classList.add("unlock-package-card");
                card.setAttribute("data-id", pkg.id);

                card.innerHTML = `
                    <h4 class="unlock-package-name">${pkg.name}</h4>
                    <p class="unlock-package-desc">${pkg.description}</p>
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

/** ───────────── SINGOLO PACCHETTO ───────────── **/
function loadSinglePackage(pkgId) {
    const container = document.querySelector(`#unlock-single-package-${pkgId}`);
    if (!container) return;

    const token = getToken();
    container.innerHTML = "<p>Caricamento dettagli…</p>";

    fetch(`${API_BASE}/packages/${pkgId}`, {
        headers: token
            ? { "Authorization": `Bearer ${token}`, "Accept": "application/json" }
            : { "Accept": "application/json" }
    })
    .then(res => res.json())
    .then(pkg => {
        container.innerHTML = `
            <h4 class="unlock-package-name">${pkg.name}</h4>
            <p class="unlock-package-desc">${pkg.description}</p>
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

/** ───────────── ACQUISTA PACCHETTO ───────────── **/
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

/** ───────────── EVENT LISTENERS ───────────── **/
function setupunlockWidgets() {
    // Login
    const btnLogin = document.querySelector("#unlock-btn-login");
    if (btnLogin) btnLogin.addEventListener("click", doLogin);

    //signup
    const signupForm = document.querySelector("#unlock-signup-form");
    if (signupForm) {
        signupForm.addEventListener("submit", function(e) {
            e.preventDefault();
            doSignup();
        });
    }

    // Se l’utente è già loggato, nascondi il form
    if (getToken()) {
        hideSignupForm();
    }

    // Lista pacchetti
    if (document.querySelector("#unlock-packages-list")) {
        loadPackagesList();
    }

    // Singolo pacchetto: cerchiamo tutti i container che hanno attributo data-package-id
    document.querySelectorAll("[id^='unlock-single-package-']").forEach(div => {
        const pkgId = div.getAttribute("data-package-id");
        if (pkgId) {
            loadSinglePackage(pkgId);
        }
    });

    // Acquisto (delegazione)
    document.addEventListener("click", function(e) {
        if (e.target.matches(".unlock-buy-btn")) {
            const pkgId = e.target.getAttribute("data-id");
            doPurchase(pkgId);
        }
    });
}

document.addEventListener("DOMContentLoaded", setupunlockWidgets);
