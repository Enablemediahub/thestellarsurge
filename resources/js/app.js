import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

const installButton = document.querySelector('[data-pwa-install]');
let deferredPrompt = null;

window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault();
    deferredPrompt = event;

    if (installButton) {
        installButton.hidden = false;
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
        installButton.hidden = true;
    });
}
