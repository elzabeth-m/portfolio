
window.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);
  if (params.get("status") === "success") {
    const successMessage = document.createElement("p");
    successMessage.textContent = "Your message was sent successfully!";
    successMessage.style.color = "green";
    successMessage.style.marginTop = "1rem";
    successMessage.style.fontWeight = "bold";

    const contactSection = document.querySelector("#contact .contact-container");
    if (contactSection) {
      contactSection.insertBefore(successMessage, contactSection.querySelector("form"));
    }
  }
});