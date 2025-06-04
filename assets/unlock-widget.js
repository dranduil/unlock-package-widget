const API_BASE = "https://api.flexa.life/api";

function setToken(token) {
    document.cookie = `flexa_token=${token}; path=/`;
}

function getToken() {
    const match = document.cookie.match(/(^| )flexa_token=([^;]+)/);
    return match ? match[2] : null;
}

function flexaLogin() {
    const email = document.getElementById("flexa_email").value;
    const password = document.getElementById("flexa_password").value;

    fetch(`${API_BASE}/login`, {
        method: "POST",
        headers: { "Content-Type": "application/json", "Accept": "application/json" },
        body: JSON.stringify({ email, password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.token) {
            setToken(data.token);
            alert("Login effettuato");
            loadPackages();
            loadUser();
        } else {
            alert("Login fallito");
        }
    });
}

function flexaRegister() {
    const email = document.getElementById("flexa_reg_email").value;
    const password = document.getElementById("flexa_reg_password").value;

    fetch(`${API_BASE}/sign-up`, {
        method: "POST",
        headers: { "Content-Type": "application/json", "Accept": "application/json" },
        body: JSON.stringify({ email, password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.token) {
            setToken(data.token);
            alert("Registrazione completata");
            loadPackages();
            loadUser();
        } else {
            alert("Errore durante la registrazione");
        }
    });
}

function loadUser() {
    const token = getToken();
    if (!token) return;

    fetch(`${API_BASE}/user`, {
        headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" }
    })
    .then(res => res.json())
    .then(user => {
        document.getElementById("flexa-user-info").style.display = "block";
        document.getElementById("flexa-user-info").innerHTML = `<strong>Benvenuto, ${user.name || user.email}</strong>`;
    });
}

function loadPackages() {
    const token = getToken();

    fetch(`${API_BASE}/packages`, {
        headers: token ? { "Authorization": `Bearer ${token}` } : {}
    })
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById("flexa-packages");
        container.innerHTML = "";
        if (Array.isArray(data)) {
            data.forEach(pkg => {
                const el = document.createElement("div");
                el.innerHTML = `
                    <h4>${pkg.name}</h4>
                    <p>${pkg.description}</p>
                    <p>Prezzo: ${pkg.price}</p>
                    <ul>${pkg.features.map(f => `<li>${f}</li>`).join('')}</ul>
                    <button onclick="buyPackage(${pkg.id})">Acquista</button>
                `;
                container.appendChild(el);
            });
        } else {
            container.innerHTML = "<p>Nessun pacchetto trovato.</p>";
        }
    });
}

function buyPackage(id) {
    const token = getToken();
    if (!token) return alert("Devi essere loggato");

    fetch(`${API_BASE}/purchase-package`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`,
            "Accept": "application/json"
        },
        body: JSON.stringify({ package_id: id })
    })
    .then(res => res.json())
    .then(data => {
        alert("Acquisto completato!");
    });
}

document.addEventListener("DOMContentLoaded", () => {
    if (getToken()) {
        loadUser();
    }
    loadPackages();
});
