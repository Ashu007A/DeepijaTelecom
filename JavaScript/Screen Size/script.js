function updateSize() {
    const width = window.innerWidth;
    const height = window.innerHeight;
    const sizeInfo = document.getElementById('screenSize');
    sizeInfo.textContent = `Width: ${width} and Height: ${height}`;
}

window.addEventListener('resize', updateSize);

// Initial size update
updateSize();