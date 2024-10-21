// Function to get a cookie by name
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

// Function to set a cookie
function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days*24*60*60*1000));
    const expires = `expires=${date.toUTCString()}`;
    document.cookie = `${name}=${value}; ${expires}; path=/`;
}

// Apply saved preferences
window.onload = function() {
    const savedFontSize = getCookie('fontsize');
    const savedFontColor = getCookie('fontcolor');
    
    if (savedFontSize) {
        document.body.style.fontSize = `${savedFontSize}px`;
        document.getElementById('fontsize').value = savedFontSize;
    }
    
    if (savedFontColor) {
        document.body.style.color = savedFontColor;
        document.getElementById('fontcolor').value = savedFontColor;
    }
};

// Handle form submission
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const fontSize = document.getElementById('fontsize').value;
    const fontColor = document.getElementById('fontcolor').value;

    // Save preferences in cookies
    setCookie('fontsize', fontSize, 365);
    setCookie('fontcolor', fontColor, 365);

    // Apply preferences to the page
    document.body.style.fontSize = `${fontSize}px`;
    document.body.style.color = fontColor;

    alert('Preferences saved!');
});