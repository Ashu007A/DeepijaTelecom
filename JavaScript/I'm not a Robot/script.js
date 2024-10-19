document.addEventListener('DOMContentLoaded', () => {
    const images = ['img1', 'img2', 'img3', 'img4', 'img5'];
    let selectedImages = [];
    let repeatedImage = images[Math.floor(Math.random() * images.length)];
    let allImages = [...images, repeatedImage];
    allImages = allImages.sort(() => Math.random() - 0.5);
  
    function renderImages() {
      const container = document.getElementById('image-container');
      container.innerHTML = '';
      allImages.forEach((imgClass, index) => {
        const img = document.createElement('img');
        img.className = imgClass;
        img.onclick = () => selectImage(img, index);
        container.appendChild(img);
      });
    }
  
    function selectImage(img, index) {
      if (selectedImages.includes(index)) return;
      img.classList.add('selected');
      selectedImages.push(index);
      document.getElementById('reset').style.display = 'block';
      if (selectedImages.length === 2) {
        document.getElementById('verify').style.display = 'block';
      }
    }
  
    function resetState() {
      selectedImages = [];
      document.getElementById('reset').style.display = 'none';
      document.getElementById('verify').style.display = 'none';
      document.getElementById('para').innerText = '';
      renderImages();
    }
  
    function verifySelection() {
      const [first, second] = selectedImages;
      const firstImageClass = allImages[first];
      const secondImageClass = allImages[second];
      document.getElementById('verify').style.display = 'none';
      if (firstImageClass === secondImageClass) {
        document.getElementById('para').innerText = 'You are a human. Congratulations!';
      } else {
        document.getElementById('para').innerText = "We can't verify you as a human. You selected the non-identical tiles.";
      }
    }
  
    // Ensure functions are accessible globally
    window.resetState = resetState;
    window.verifySelection = verifySelection;
  
    renderImages();
  });