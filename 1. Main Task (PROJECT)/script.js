document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const stateSelect = document.getElementById("state");
    const districtSelect = document.getElementById("district");
    const citySelect = document.getElementById("city");
  
    // Load states
    fetch('json/states.json')
      .then(response => response.json())
      .then(states => {
        states.forEach(state => {
          let option = document.createElement("option");
          option.value = state.id;
          option.text = state.name;
          stateSelect.appendChild(option);
        });
      });
  
    // Load districts
    stateSelect.addEventListener("change", function() {
      fetch('json/districts.json')
        .then(response => response.json())
        .then(data => {
          const districts = data[this.value];
          districtSelect.innerHTML = "";
          citySelect.innerHTML = "";
          districts.forEach(district => {
            let option = document.createElement("option");
            option.value = district.id;
            option.text = district.name;
            districtSelect.appendChild(option);
          });
        });
    });
  
    // Load cities
    districtSelect.addEventListener("change", function() {
      fetch('json/cities.json')
        .then(response => response.json())
        .then(data => {
          const cities = data[this.value];
          citySelect.innerHTML = "";
          cities.forEach(city => {
            let option = document.createElement("option");
            option.value = city.id;
            option.text = city.name;
            citySelect.appendChild(option);
          });
        });
    });
  
    // Validation
    form.addEventListener("submit", function(event) {
      let isValid = true;
  
      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value;
      const repassword = document.getElementById("repassword").value;
      const email = document.getElementById("email").value;
  
      if (username === "") {
        isValid = false;
        alert("Username cannot be empty");
      }
  
      if (password !== repassword) {
        isValid = false;
        alert("Passwords do not match");
      }
  
      // Simple email regex for demo purposes
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email)) {
        isValid = false;
        alert("Invalid email format");
      }
  
      if (!isValid) {
        event.preventDefault();
      }
    });
});  