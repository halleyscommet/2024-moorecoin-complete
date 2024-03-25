window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get("success");

    if (success) {
        const messageDiv = document.createElement("div");
        messageDiv.id = "error-message";
        messageDiv.textContent = success;
        document.body.appendChild(messageDiv);
    }
}