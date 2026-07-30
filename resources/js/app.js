import './bootstrap';
import preferences from "./core/preferences";

preferences.init();

window.preferences = preferences;
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
