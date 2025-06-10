const API_BASE = "https://api.unlockthemove.com/api";

function setToken(token) {
    document.cookie = `unlock_token=${token}; path=/`;
}

function getToken() {
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
        cookie = cookie.trim();
        if (cookie.startsWith('unlock_token=')) {
            return cookie.substring('unlock_token='.length);
        }
    }
    return null;
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
    .then(res => {
        console.log('API Response Status:', res.status); // DEBUG: Log API response status
        if (!res.ok) {
            // Try to parse error response if it's JSON, otherwise use statusText
            return res.json().catch(() => null).then(errorData => {
                throw new Error(`HTTP error ${res.status}: ${errorData ? JSON.stringify(errorData) : res.statusText}`);
            });
        }
        return res.json();
    })
    .then(data => {
        if (data.token) {
            setToken(data.token);
            if (msgDiv) msgDiv.innerText = "Login successful.";

            // Redirect se configurato e non vuoto
            if (redirectUrl && redirectUrl.trim() !== '') {
                window.location.href = redirectUrl;
                return;
            }

            // Altrimenti, carica pacchetti e profilo
            loadPackagesList();
            loadUserProfile();
        } else {
            if (msgDiv) msgDiv.innerText = "Login failed.";
        }
    })
    .catch(err => {
        console.error(err);
        if (msgDiv) msgDiv.innerText = "Errore di connessione.";
    });
}

/** ─── SIGNUP ─────────────────────────────── **/
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
        if (msgDiv) msgDiv.innerText = "All fields are mandatory.";
        return;
    }
    if (password !== confirm) {
        if (msgDiv) msgDiv.innerText = "The passwords do not match.";
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
    .then(res => {
        console.log('API Response Status:', res.status); // DEBUG: Log API response status
        if (!res.ok) {
            // Try to parse error response if it's JSON, otherwise use statusText
            return res.json().catch(() => null).then(errorData => {
                throw new Error(`HTTP error ${res.status}: ${errorData ? JSON.stringify(errorData) : res.statusText}`);
            });
        }
        return res.json();
    })
    .then(data => {
        if (data.token) {
            setToken(data.token);
            if (msgDiv) msgDiv.innerText = "Registration successful.";

            // Redirect se configurato e non vuoto
            if (redirectUrl && redirectUrl.trim() !== '') {
                window.location.href = redirectUrl;
                return;
            }

            hideSignupForm();
            loadUserProfile();
        } else {
            let errorMsg = "Registration failed.";
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
        if (msgDiv) msgDiv.innerText = "Connection error.";
    });
}

/** ─── LISTA PACCHETTI ───────────────────────────────────── **/
function loadPackagesList() {
    const container = document.querySelector("#unlock-packages-list");
    if (!container) return;

    const token = getToken();
    container.innerHTML = "<p>Loading packages…</p>";

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
                const item = document.createElement("div");
                item.classList.add("unlock-package-item");
                item.setAttribute("data-id", pkg.id);

                const imageUrl = pkg.image_url && pkg.image_url.trim() !== '' ? pkg.image_url : 'https://via.placeholder.com/300x300.png?text=Package+Image'; // Placeholder for 1x1 image

                // Image Container
                const imageContainer = document.createElement('div');
                imageContainer.classList.add('unlock-package-image-container');
                const imageEl = document.createElement('img');
                imageEl.classList.add('unlock-package-image');
                imageEl.src = imageUrl;
                imageEl.alt = pkg.name || 'Package image';
                imageContainer.appendChild(imageEl);
                item.appendChild(imageContainer);

                // Content Container
                const contentContainer = document.createElement('div');
                contentContainer.classList.add('unlock-package-content');

                const nameEl = document.createElement("h4");
                nameEl.classList.add("unlock-package-name");
                nameEl.textContent = pkg.name;
                contentContainer.appendChild(nameEl);

                const descEl = document.createElement("p");
                descEl.classList.add("unlock-package-description");
                descEl.textContent = pkg.description || '';
                contentContainer.appendChild(descEl);

                const priceEl = document.createElement("p");
                priceEl.classList.add("unlock-package-price");
                // Assuming pkg.price is just the number, and currency is handled elsewhere or can be added
                priceEl.innerHTML = pkg.price; // Example currency
                contentContainer.appendChild(priceEl);

                // Features list
                if (pkg.features && Array.isArray(pkg.features) && pkg.features.length > 0) {
                    const featuresList = document.createElement('ul');
                    featuresList.classList.add('unlock-package-features'); // Add a class for styling
                    pkg.features.forEach(f => {
                        const featureItem = document.createElement('li');
                        featureItem.textContent = f;
                        featuresList.appendChild(featureItem);
                    });
                    contentContainer.appendChild(featuresList);
                }

                const buyButton = document.createElement("a"); // Changed to <a> for better styling as a button
                buyButton.classList.add("unlock-package-details-link"); // Re-using class from single for consistency or create new
                buyButton.href = "#"; // Or link to a details page / purchase action
                buyButton.setAttribute("data-id", pkg.id);
                buyButton.textContent = "Buy"; // Or "Details"
                buyButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    doPurchase(pkg.id);
                });
                contentContainer.appendChild(buyButton);

                item.appendChild(contentContainer);
                container.appendChild(item);
            });
        } else {
            container.innerHTML = "<p>No packages available.</p>";
        }
    })
    .catch(err => {
        console.error(err);
        container.innerHTML = "<p>Error loading packages.</p>";
    });
}

/** ─── SINGOLO PACCHETTO ─────────────────────────────────── **/
function loadSinglePackage(pkgId) {
    const container = document.querySelector(`#unlock-single-package-${pkgId}`);
    if (!container) return;

    const token = getToken();
    container.innerHTML = "<p>Loading details…</p>";

    fetch(`${API_BASE}/stripe/packages/${pkgId}`, {
        headers: token
            ? { "Authorization": `Bearer ${token}`, "Accept": "application/json" }
            : { "Accept": "application/json" }
    })
    .then(res => res.json())
    .then(response => {
        const pkg = response.data || response;
        container.innerHTML = ''; // Clear loading message

        const item = document.createElement('div');
        item.classList.add('unlock-single-package-details'); // Use a specific class for single view if needed or reuse general item class

        const imageUrl = pkg.image_url && pkg.image_url.trim() !== '' ? pkg.image_url : 'https://via.placeholder.com/300x300.png?text=Package+Image';

        const imageContainer = document.createElement('div');
        imageContainer.classList.add('unlock-package-image-container'); // Re-use class from list for consistency
        const imageEl = document.createElement('img');
        imageEl.classList.add('unlock-package-image');
        imageEl.src = imageUrl;
        imageEl.alt = pkg.name || 'Package image';
        imageContainer.appendChild(imageEl);
        item.appendChild(imageContainer);

        const contentContainer = document.createElement('div');
        contentContainer.classList.add('unlock-package-content'); // Re-use class from list for consistency

        const nameEl = document.createElement("h4");
        nameEl.classList.add("unlock-single-package-name"); // Specific class for single view title
        nameEl.textContent = pkg.name;
        contentContainer.appendChild(nameEl);

        const descEl = document.createElement("p");
        descEl.classList.add("unlock-single-package-description"); // Specific class for single view description
        descEl.textContent = pkg.description || '';
        contentContainer.appendChild(descEl);

        const priceEl = document.createElement("p");
        priceEl.classList.add("unlock-single-package-price"); // Specific class for single view price
        priceEl.innerHTML = `${pkg.price} <span class="unlock-package-currency">EUR</span>`;
        contentContainer.appendChild(priceEl);

        if (pkg.features && Array.isArray(pkg.features) && pkg.features.length > 0) {
            const featuresTitle = document.createElement('h5');
            featuresTitle.classList.add('unlock-single-package-features-title');
            featuresTitle.textContent = 'Features:'; // Or make this configurable
            contentContainer.appendChild(featuresTitle);

            const featuresList = document.createElement('ul');
            featuresList.classList.add('unlock-single-package-features-list');
            pkg.features.forEach(f => {
                const featureItem = document.createElement('li');
                featureItem.textContent = f;
                featuresList.appendChild(featureItem);
            });
            contentContainer.appendChild(featuresList);
        }

        const purchaseButton = document.createElement("button");
        purchaseButton.classList.add("unlock-package-purchase-button"); // Use the new M3 style button class
        purchaseButton.setAttribute("data-id", pkg.id);
        purchaseButton.textContent = "Buy Now";
        purchaseButton.addEventListener('click', (e) => {
            e.preventDefault();
            doPurchase(pkg.id, container); // Pass container for messages
        });
        contentContainer.appendChild(purchaseButton);
        
        // Message area for purchase feedback
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('unlock-purchase-message');
        messageDiv.style.marginTop = '15px';
        contentContainer.appendChild(messageDiv);

        item.appendChild(contentContainer);
        container.appendChild(item);

    })
    .catch(err => {
        console.error(err);
        container.innerHTML = "<p>Error loading package.</p>";
    });
}

/** ─── Purchase Package ─────────────────────────────────── **/
// Initialize Stripe globally
let stripe = null;
let elements = null;
let defaultPaymentMethodId = null;

// Initialize Stripe when the script loads
document.addEventListener('DOMContentLoaded', () => {
    if (typeof unlockStripeSettings !== 'undefined' && unlockStripeSettings.publishableKey) {
        stripe = Stripe(unlockStripeSettings.publishableKey);
        elements = stripe.elements();
    } else {
        console.error('Stripe publishable key not found');
    }
});

// Create and show Stripe payment modal
async function showStripePaymentModal() {
    return new Promise((resolve, reject) => {
        // Create modal container
        const modalContainer = document.createElement('div');
        modalContainer.className = 'unlock-stripe-modal';
        modalContainer.innerHTML = `
            <div class="unlock-stripe-modal-content">
                <div class="unlock-stripe-modal-header">
                    <h3>Add Payment Method</h3>
                    <button class="unlock-stripe-modal-close">&times;</button>
                </div>
                <div class="unlock-stripe-modal-body">
                    <form id="unlock-payment-form">
                        <div id="unlock-card-element"></div>
                        <div id="unlock-card-errors" role="alert"></div>
                        <button type="submit" class="unlock-stripe-submit">Add Payment Method</button>
                    </form>
                </div>
            </div>
        `;

        // Add modal styles
        const style = document.createElement('style');
        style.textContent = `
            .unlock-stripe-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.75);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }
            .unlock-stripe-modal-content {
                background: white;
                padding: 30px;
                border-radius: 12px;
                width: 90%;
                max-width: 500px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .unlock-stripe-modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 25px;
            }
            .unlock-stripe-modal-header h3 {
                color: black;
                margin: 0;
                font-size: 24px;
                font-weight: 600;
            }
            .unlock-stripe-modal-close {
                background: none;
                border: none;
                font-size: 28px;
                cursor: pointer;
                color: black;
                padding: 5px;
                line-height: 1;
                transition: opacity 0.2s;
            }
            .unlock-stripe-modal-close:hover {
                opacity: 0.7;
            }
            #unlock-card-element {
                padding: 15px;
                border: 2px solid #e0e0e0;
                border-radius: 8px;
                margin-bottom: 25px;
                background: white;
                transition: border-color 0.2s;
            }
            #unlock-card-element:focus-within {
                border-color: #ffd700;
            }
            .unlock-stripe-submit {
                background: #ffd700;
                color: black;
                padding: 15px 30px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                width: 100%;
                font-size: 16px;
                font-weight: 600;
                transition: all 0.2s;
            }
            .unlock-stripe-submit:hover {
                background: #ffed4a;
                transform: translateY(-1px);
            }
            .unlock-stripe-submit:active {
                transform: translateY(1px);
            }
            #unlock-card-errors {
                color: #dc3545;
                margin-bottom: 15px;
                font-size: 14px;
                min-height: 20px;
            }
        `;

        document.head.appendChild(style);
        document.body.appendChild(modalContainer);

        // Set up Stripe Elements
        const cardElement = elements.create('card');
        cardElement.mount('#unlock-card-element');

        // Handle form submission
        const form = document.getElementById('unlock-payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            });

            if (error) {
                const errorElement = document.getElementById('unlock-card-errors');
                errorElement.textContent = error.message;
                reject(error);
            } else {
                modalContainer.remove();
                resolve(paymentMethod.id);
            }
        });

        // Handle modal close
        const closeBtn = modalContainer.querySelector('.unlock-stripe-modal-close');
        closeBtn.addEventListener('click', () => {
            modalContainer.remove();
            reject(new Error('Modal closed'));
        });
    });
}

// Update doPurchase function to handle payment method creation
async function doPurchase(pkgId, messageContainerElement) {
    // if messageContainerElement is not provided, try to find a general one or default to alert
    let msgDisplay = messageContainerElement;
    if (!msgDisplay) {
        // Attempt to find a general message display area if one exists for the list view
        // This part might need a more robust selector if multiple widgets are on the page
        const listContainer = document.querySelector("#unlock-packages-list");
        if (listContainer) {
            msgDisplay = listContainer.querySelector(`.unlock-package-item[data-id="${pkgId}"] .unlock-purchase-message`);
            if (!msgDisplay) { // if not found within item, maybe a general message area for the list
                 msgDisplay = listContainer.querySelector('.unlock-list-purchase-message');
                 if(!msgDisplay){
                    const tempMsgDiv = document.createElement('div');
                    tempMsgDiv.classList.add('unlock-list-purchase-message');
                    listContainer.prepend(tempMsgDiv); // Add to top of list
                    msgDisplay = tempMsgDiv;
                 }
            }
        }
    }

    const showMessage = (message, isError = false) => {
        if (msgDisplay && msgDisplay instanceof HTMLElement) {
            msgDisplay.textContent = message;
            msgDisplay.className = 'unlock-purchase-message'; // Reset classes
            msgDisplay.classList.add(isError ? 'error' : 'success');
            // Simple styling for visibility, ideally handled by CSS
            msgDisplay.style.padding = '10px';
            msgDisplay.style.marginTop = '10px';
            msgDisplay.style.borderRadius = '4px';
            msgDisplay.style.border = '1px solid';
            msgDisplay.style.borderColor = isError ? '#d9534f' : '#28a745';
            msgDisplay.style.color = isError ? '#d9534f' : '#28a745';
            msgDisplay.style.backgroundColor = isError ? '#f2dede' : '#dff0d8';
        } else {
            alert(message);
        }
    };
    const token = getToken();
    if (!token) {
        alert("Devi essere loggato.");
        return;
    }

    let paymentMethodId = defaultPaymentMethodId;

    if (!paymentMethodId) {
        try {
            // Show Stripe modal and get new payment method ID
            paymentMethodId = await showStripePaymentModal();
        } catch (error) {
            console.error('Payment method creation failed:', error);
            showMessage("Payment method creation failed. Please try again.", true);
            return;
        }
    }

    const purchasePayload = { 
        package_id: parseInt(pkgId),
        payment_method_id: paymentMethodId
    };

    fetch(`${API_BASE}/purchase-package`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`,
            "Accept": "application/json"
        },
        body: JSON.stringify(purchasePayload)
    })
    .then(res => {
        if (!res.ok) {
            return res.text().then(text => {
                try {
                    const errorData = JSON.parse(text);
                    const errorMessage = errorData?.message || errorData?.error || `Error: ${res.status} ${res.statusText}`;
                    throw new Error(errorMessage);
                } catch (e) {
                    throw new Error(`Request failed: ${res.status} ${res.statusText}. ${text || ''}`.trim());
                }
            });
        }
        return res.json();
    })
    .then(data => {
        const successMessage = data?.message || "Package purchased successfully!";
        showMessage(successMessage, false);
    })
    .catch(err => {
        console.error(err);
        showMessage(err.message || "Error during purchase. Please try again.", true);
    });
}

/** ─── PROFILE ─────────────────────────────────────────── **/
async function loadUserProfile() {
    console.log('loadUserProfile called'); 
    defaultPaymentMethodId = null; // Reset before loading
    const wrapper = document.querySelector(".unlock-profile-widget"); 
    if (!wrapper) {
        console.error('Profile wrapper .unlock-profile-widget not found. Exiting loadUserProfile.');
        return;
    }

    const settingsElement = wrapper.querySelector(".unlock-profile-settings");
    if (!settingsElement) {
        console.error('Settings element .unlock-profile-settings not found within wrapper. Exiting loadUserProfile.');
        return;
    }

    const settings = JSON.parse(settingsElement.dataset.settings || '{}');
    const nonce = wrapper.dataset.nonce; // Assuming nonce is still on the main wrapper
    const redirectUrl = wrapper.dataset.redirectUrl || "";
    const contentDiv  = document.querySelector("#unlock-profile-content");
    const token       = getToken();
    
    console.log(token);

    // Authentication check: if not logged in and redirect URL is provided, redirect.
    if (!token) {
        console.log('User not authenticated.');
        if (redirectUrl) {
            console.log('Redirecting to:', redirectUrl);
            window.location.href = redirectUrl;
        } else if (contentDiv) {
            console.log('Displaying "You must be logged in" message.');
            contentDiv.innerHTML = "<p>You must be logged in to view this content.</p>";
        }
        return; // Stop further execution if not authenticated
    }

    if (contentDiv) {
        contentDiv.innerHTML = '<p class="unlock-loading-message">Loading profile details...</p>';
    }

    try {
        console.log('Fetching user profile data from:', `${API_BASE}/user`);
        const response = await fetch(`${API_BASE}/user`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-WP-Nonce': nonce,
                'Authorization': `Bearer ${token}`
            }
        });
        console.log('Fetch response received:', response.status);

        if (!response.ok) {
            let errorData = { message: response.statusText }; // Default error message
            try {
                 errorData = await response.json();
            } catch (e) {
                console.warn('Could not parse error response as JSON.');
            }
            console.error('Error fetching profile (not ok):', response.status, errorData.message || response.statusText);
            if (contentDiv) contentDiv.innerHTML = `<p>Error loading profile: ${errorData.message || response.statusText}</p>`;
            return;
        }

        const data = await response.json();

        let html = "";

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
        console.log(settings);
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
                    // Add data-id attribute to the list item
                    html += `<li data-id="${pm.id}">${pm.brand || pm.type || "–"} ending in ${pm.last4 || "-"}${isDefault}</li>`;
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
    }
    catch(err) {
        console.error('Error loading user profile:', err); // DEBUG: Log any error during fetch or processing
        if (contentDiv) {
            contentDiv.innerHTML = "<p>Error loading profile.</p>";
        }
    };
}

/** ─── SETUP EVENT LISTENERS ─────────────────────────────────────────────────┐ **/
function setupUnlockWidgets() {
    const token = getToken();
    console.log('setupUnlockWidgets function called'); // DEBUG: Log function call

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

    // ───── Purchase package ───────────────────────────────────
    document.addEventListener("click", function(e) {
        if (e.target.matches(".unlock-buy-btn")) {
            const pkgId = e.target.getAttribute("data-id");
            doPurchase(pkgId);
        }
    });

    // ───── PROFILE ───────────────────────────────────────────
    if (document.querySelector(".unlock-profile-widget")) {
        loadUserProfile();
    }
}

document.addEventListener("DOMContentLoaded", setupUnlockWidgets);
/** ─────────────────────────────────────────────────────────────────────────────────────┘ **/
