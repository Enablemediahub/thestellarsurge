import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

const installPrompt = document.querySelector('[data-install-prompt]');
const installButton = document.querySelector('[data-install-app]');
const installDismiss = document.querySelector('[data-install-dismiss]');
const cookieBanner = document.querySelector('[data-cookie-banner]');
const cookieAccept = document.querySelector('[data-cookie-accept]');
const cookieDismiss = document.querySelector('[data-cookie-dismiss]');
let deferredPrompt = null;

if (cookieBanner && !localStorage.getItem('stellar-surge-cookie-choice')) {
    cookieBanner.hidden = false;
}

const closeCookieBanner = (choice) => {
    localStorage.setItem('stellar-surge-cookie-choice', choice);

    if (cookieBanner) {
        cookieBanner.hidden = true;
    }
};

cookieAccept?.addEventListener('click', () => closeCookieBanner('accepted'));
cookieDismiss?.addEventListener('click', () => closeCookieBanner('dismissed'));

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => navigator.serviceWorker.register('/sw.js').catch(() => {}));
}

window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault();
    deferredPrompt = event;

    if (installPrompt && !localStorage.getItem('stellar-surge-install-dismissed')) {
        installPrompt.hidden = false;
    }
});

if (installButton) {
    installButton.addEventListener('click', async () => {
        if (!deferredPrompt) {
            return;
        }

        deferredPrompt.prompt();
        await deferredPrompt.userChoice;
        deferredPrompt = null;
        installPrompt.hidden = true;
    });
}

installDismiss?.addEventListener('click', () => {
    localStorage.setItem('stellar-surge-install-dismissed', 'true');
    installPrompt.hidden = true;
});
