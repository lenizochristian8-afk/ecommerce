import './bootstrap';
import '../css/app.css';
//import 'alpinejs';
import 'preline';

document.addEventListener('livewire:navigated', () => {

    window.HSStaticMethods.autoInit();
})