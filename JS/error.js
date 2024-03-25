window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get("error");

    if (error) {
        const messageDiv = document.createElement("div");
        messageDiv.id = "error-message";
        messageDiv.textContent = error;
        document.body.appendChild(messageDiv);
    }
}