let angle = 0;
const line = document.getElementById('line');

function rotateLine() {
    angle += 2;
    line.style.transform = `rotate(${angle}deg)`;
    requestAnimationFrame(rotateLine);
}

rotateLine();