const API_BASE = "https://api.flexa.life/api";

function setToken(token) {
    document.cookie = `unlock_token=${token}; path=/`;
}
function getToken() {
    const match = document.cookie.match(/(^| )unlock_token=([^;]+)/);
    return match ? match[2] : null;
}

// 1) LOGIN
function loginAction() {
    const email = document.querySelector("#login_email")?.value;
    const password = document.querySelector("#login_password")?.value;
    if (!email || !password) {
        alert("Please enter email & password.");
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
            alert("Login successful");
            fetchPackages();
            loadUserInfo();
        } else {
            alert("Login failed");
        }
    })
    .catch(err => {
        console.error(err);
        alert("Error connecting to API.");
    });
}

// 2) REGISTER
function registerAction() {
    const email = document.querySelector("#register_email")?.value;
    const password = document.querySelector("#register_password")?.value;
    if (!email || !password) {
        alert("Please enter email & password.");
        return;
    }

    fetch(`${API_BASE}/sign-up`, {
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
            alert("Registration successful");
            fetchPackages();
            loadUserInfo();
        } else {
            alert("Registration failed");
        }
    })
    .catch(err => {
        console.error(err);
        alert("Error connecting to API.");
    });
}

// 3) LOAD CURRENT USER INFO
function loadUserInfo() {
    const token = getToken();
    if (!token) return;

    fetch(`${API_BASE}/user`, {
        headers: {
            "Authorization": `Bearer ${token}`,
            "Accept": "application/json"
        }
    })
    .then(res => res.json())
    .then(user => {
        const infoDiv = document.querySelector("#unlock-user-info");
        if (!infoDiv) return;
        infoDiv.style.display = "block";
        infoDiv.innerHTML = `<strong>Welcome, ${user.name || user.email}</strong>`;
    });
}

// 4) FETCH PACKAGES
function fetchPackages() {
    const token = getToken();
    fetch(`${API_BASE}/packages`, {
        headers: token
            ? { "Authorization": `Bearer ${token}`, "Accept": "application/json" }
            : { "Accept": "application/json" }
    })
    .then(res => res.json())
    .then(data => {
        const container = document.querySelector("#package_container");
        if (!container) return;
        container.innerHTML = ""; // Clear “Loading…” text

        if (Array.isArray(data) && data.length) {
            data.forEach(pkg => {
                // Create a simple package card—Elementor styles will override as needed
                const card = document.createElement("div");
                card.classList.add("unlock-package-card");
                card.setAttribute("data-id", pkg.id);

                const html = `
                    <h4 class="unlock-package-name">${pkg.name}</h4>
                    <p class="unlock-package-desc">${pkg.description}</p>
                    <p class="unlock-package-price">${pkg.price}</p>
                    <ul class="unlock-package-features">
                        ${pkg.features.map(f => `<li>${f}</li>`).join("")}
                    </ul>
                    <button class="unlock-btn buy-package" data-id="${pkg.id}">
                        Buy
                    </button>
                `;
                card.innerHTML = html;
                container.appendChild(card);
            });
        } else {
            container.innerHTML = `<p>No packages available.</p>`;
        }
    })
    .catch(err => {
        console.error(err);
        const container = document.querySelector("#package_container");
        if (container) container.innerHTML = `<p>Error loading packages.</p>`;
    });
}

// 5) PURCHASE PACKAGE
function purchasePackage(id) {
    const token = getToken();
    if (!token) {
        alert("You must be logged in.");
        return;
    }

    fetch(`${API_BASE}/purchase-package`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`,
            "Accept": "application/json"
        },
        body: JSON.stringify({ package_id: parseInt(id) })
    })
    .then(res => res.json())
    .then(resp => {
        alert("Package purchased successfully!");
        // Optionally dispatch event or reload user info
    })
    .catch(err => {
        console.error(err);
        alert("Error purchasing package.");
    });
}

// 6) Wire up DOM Events
function setupEventListeners() {
    // LOGIN BUTTON
    const btnLogin = document.querySelector("#btn_login");
    if (btnLogin) {
        btnLogin.addEventListener("click", loginAction);
    }

    // REGISTER BUTTON
    const btnRegister = document.querySelector("#btn_register");
    if (btnRegister) {
        btnRegister.addEventListener("click", registerAction);
    }

    // WHEN A “Buy” BUTTON IS CLICKED (delegation)
    document.addEventListener("click", function(e) {
        if (e.target && e.target.matches(".buy-package")) {
            const pkgId = e.target.getAttribute("data-id");
            purchasePackage(pkgId);
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    setupEventListeners();

    // If already logged in, show user and packages immediately
    if (getToken()) {
        loadUserInfo();
    }
    fetchPackages();
});