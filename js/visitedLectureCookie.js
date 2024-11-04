// Function to set a cookie
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// Function to get a cookie by name
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Function to track button clicks
function trackButtonClick(buttonId) {
    let clickedButtons = getCookie('clickedButtons');
    if (clickedButtons) {
        clickedButtons = clickedButtons.split(',').map(id => id.trim());
    } else {
        clickedButtons = [];
    }
    
    if (!clickedButtons.includes(buttonId)) {
        clickedButtons.push(buttonId);
        setCookie('clickedButtons', clickedButtons.join(','), 7); // Save for 7 days
    }
}

// Function to check clicked buttons on page load
function checkClickedButtons() {
    const clickedButtons = getCookie('clickedButtons');
    if (clickedButtons) {
        clickedButtons.split(',').forEach(id => {
            const button = document.getElementById(id.trim());
            if (button) {
                button.parentElement.classList.add('visited'); // Change color for clicked buttons
            }
        });
    }
}

// Add click event listeners to buttons
document.addEventListener('DOMContentLoaded', () => {
    checkClickedButtons();
    
    document.getElementById('lect1').addEventListener('click', () => trackButtonClick('lect1'));
    document.getElementById('lect2').addEventListener('click', () => trackButtonClick('lect2'));
    document.getElementById('lect3').addEventListener('click', () => trackButtonClick('lect3'));
    document.getElementById('lect4').addEventListener('click', () => trackButtonClick('lect4'));
    document.getElementById('lect5').addEventListener('click', () => trackButtonClick('lect5'));
    document.getElementById('lect6').addEventListener('click', () => trackButtonClick('lect6'));
    document.getElementById('lect7').addEventListener('click', () => trackButtonClick('lect7'));
    document.getElementById('lect8').addEventListener('click', () => trackButtonClick('lect8'));
    document.getElementById('lect9').addEventListener('click', () => trackButtonClick('lect9'));
    document.getElementById('lect10').addEventListener('click', () => trackButtonClick('lect10'));

});