self.addEventListener('install', event => {
  console.log('[Service Worker] Installed');
  self.skipWaiting(); // Activate immediately after install
});

self.addEventListener('activate', event => {
  console.log('[Service Worker] Activated');
  // Clean up old caches here if needed
});

self.addEventListener('fetch', event => {
  // Passive fetch event for install prompt support (default behavior)
});
