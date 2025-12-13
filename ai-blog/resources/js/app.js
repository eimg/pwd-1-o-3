import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');
    const storedPreference = localStorage.getItem('theme');
    const initial = storedPreference ?? (prefersDark.matches ? 'dark' : 'light');

    Alpine.store('theme', {
        mode: initial,
        userSelected: Boolean(storedPreference),
        toggle() {
            this.mode = this.mode === 'dark' ? 'light' : 'dark';
            this.userSelected = true;
            this.apply();
        },
        apply() {
            document.documentElement.classList.toggle('dark', this.mode === 'dark');

            if (this.userSelected) {
                localStorage.setItem('theme', this.mode);
            } else {
                localStorage.removeItem('theme');
            }
        },
        setFromSystem(isDark) {
            if (this.userSelected) {
                return;
            }

            this.mode = isDark ? 'dark' : 'light';
            this.apply();
        },
    });

    Alpine.store('theme').apply();

    prefersDark.addEventListener('change', (event) => {
        Alpine.store('theme').setFromSystem(event.matches);
    });
});

Alpine.start();
