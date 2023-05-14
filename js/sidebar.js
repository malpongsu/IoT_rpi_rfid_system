// Get all links in the navigation menu
const links = document.querySelectorAll(".nav-links a");

// Loop through the links and add an event listener to each
links.forEach(link => {
  link.addEventListener("click", function() {
    // Remove the "active" class from all links
    links.forEach(link => link.classList.remove("active"));

    // Add the "active" class to the clicked link
    this.classList.add("active");
  });
});
