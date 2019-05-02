import './components/app-rootelement.js';
import './components/app-controlbutton.js';
import './components/app-tablebase.js';
import './data/fetchData.js';
import './data/sendData.js';

document.addEventListener('DOMContentLoaded', load_page);

function load_page() {
  checkForIE();
}

function checkForIE() {
  let isIE11 = !!window.MSInputMethodContext && !!document.documentMode;
  if (isIE11) {
    document.getElementsByClassName('container')[0].innerHTML = `<p class="warning">This code will NOT run correctly on IE11. Consider upgrading to one with the latest capabilities and security features like <a href="https://www.google.com/chrome/">chrome</a>.</p>`;  }
}