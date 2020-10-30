
function second_navbar() {
    var user_mode = document.getElementById("user_nav");
    if (user_mode.style.display === "none") {
      user_mode.style.display = "block";
      document.getElementById("mode_button").innerText = 'User Mode';
      document.getElementById("mode_button").classList.add ("btn-outline-warning");
    } else {
      user_mode.style.display = "none";
      document.getElementById("mode_button").innerText = 'Public Mode';
      document.getElementById("mode_button").classList.remove ("btn-outline-warning");
    }

  }

