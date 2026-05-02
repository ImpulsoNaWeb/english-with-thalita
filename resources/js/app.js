import './bootstrap';

import { registerSW } from 'virtual:pwa-register';

if ('serviceWorker' in navigator) {
    const updateSW = registerSW({
        onNeedRefresh() {
            console.log('Atualização do módulo PWA disponível.');
        },
        onOfflineReady() {
            console.log('Plataforma pronta para uso Offline-First.');
        },
    });
}
