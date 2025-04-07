<?php
// Create a blank image
$width = 200;
$height = 200;
$image = imagecreatetruecolor($width, $height);

// Set background color
$bgColor = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $bgColor);

// Draw clock hands (you'll need to calculate their positions based on time)

// Output the image
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>

<div class="clock">
    <div id="hours"></div>
    <div id="minutes"></div>
    <div id="seconds"></div>
</div>
<script>
    const updateInMS = 1000; // Update every second
    const clock = document.querySelector('.clock');
    const htmHours = document.getElementById('hours');
    const htmMinutes = document.getElementById('minutes');
    const htmSeconds = document.getElementById('seconds');

    function startTimer() {
        tick();
    }

    function tick() {
        setTimeout(function() {
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();

            const secondsInDegrees = (360 * seconds) / 60;
            const minutesInDegrees = (360 * minutes) / 60;
            const hoursInDegrees = (360 * hours) / 12;

            htmHours.style.transform = `rotate(${hoursInDegrees}deg)`;
            htmMinutes.style.transform = `rotate(${minutesInDegrees}deg)`;
            htmSeconds.style.transform = `rotate(${secondsInDegrees}deg)`;

            tick(); // Recurse
        }, updateInMS);
    }

    startTimer();
</script>
