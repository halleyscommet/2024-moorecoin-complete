var mousePosition = {x: 0, y: 0};
var lerpFactor = 0.025; // Adjust this to change the smoothness

var circle = document.getElementById("blurry-circle");
var circleX = 0;
var circleY = 0;

document.addEventListener("mousemove", function(e) {
    // Update the current mouse position
    mousePosition.x = e.pageX;
    mousePosition.y = e.pageY;
});

function updateCirclePosition() {
    // Use lerp to smoothly transition the circle"s position
    circleX += (mousePosition.x - circleX) * lerpFactor;
    circleY += (mousePosition.y - circleY) * lerpFactor;

    circle.style.left = circleX - 200 + "px"; // Subtract half the width
    circle.style.top = circleY - 200 + "px"; // Subtract half the height

    // Request the next frame
    requestAnimationFrame(updateCirclePosition);
}

// Start the animation
updateCirclePosition();