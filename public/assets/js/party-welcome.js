let CanvasWidth = window.innerWidth;
let header = document.getElementsByTagName("header")[0];
let footer = document.getElementsByTagName("footer")[0];

let CanvasHeight = window.innerHeight - (header.offsetHeight + footer.offsetHeight);
const canvas = document.getElementById("party-welcome");
const context = canvas.getContext("2d");
const maxConfettis = 120;
const particles = [];

const possibleColors = [
  "#AE0AC3",
  "#1801C6",
  "#F55F75",
];

function randomFromTo(from, to) {
  return Math.floor(Math.random() * (to - from + 1) + from);
}

function confettiParticle() {
    this.x = Math.random() * CanvasWidth; // x
    this.y = Math.random() * CanvasHeight - CanvasHeight; // y
  this.r = randomFromTo(11, 33); // radius
  this.d = Math.random() * maxConfettis + 11;
  this.color =
    possibleColors[Math.floor(Math.random() * possibleColors.length)];
  this.tilt = Math.floor(Math.random() * 33) - 11;
  this.tiltAngleIncremental = Math.random() * 0.07 + 0.05;
  this.tiltAngle = 0;

  this.draw = function() {
    context.beginPath();
    context.lineWidth = this.r / 3;
    context.strokeStyle = this.color;
    context.moveTo(this.x + this.tilt + this.r / 3, this.y);
    context.lineTo(this.x + this.tilt, this.y + this.tilt + this.r / 5);
    return context.stroke();
  };
}

function Draw() {
  const results = [];

  // Magical recursive functional love
  requestAnimationFrame(Draw);

    context.clearRect(0, 0, CanvasWidth, window.innerHeight);

  for (var i = 0; i < maxConfettis; i++) {
    results.push(particles[i].draw());
  }

  let particle = {};
  let remainingFlakes = 0;
  for (var i = 0; i < maxConfettis; i++) {
    particle = particles[i];

    particle.tiltAngle += particle.tiltAngleIncremental;
    particle.y += (Math.cos(particle.d) + 3 + particle.r / 2) / 2;
    particle.tilt = Math.sin(particle.tiltAngle - i / 3) * 15;

      if (particle.y <= CanvasHeight) remainingFlakes++;

    // If a confetti has fluttered out of view,
    // bring it back to above the viewport and let if re-fall.
      if (particle.x > CanvasWidth + 30 || particle.x < -30 || particle.y > CanvasHeight) {
          particle.x = Math.random() * CanvasWidth;
      particle.y = -30;
      particle.tilt = Math.floor(Math.random() * 10) - 20;
    }
  }

  return results;
}

window.addEventListener(
  "resize",
  function() {
      CanvasWidth = window.innerWidth;
      CanvasHeight = window.innerHeight;
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  },
  false
);

// Push new confetti objects to `particles[]`
for (var i = 0; i < maxConfettis; i++) {
  particles.push(new confettiParticle());
}

// Initialize
canvas.width = CanvasWidth;
canvas.height = CanvasHeight;
Draw();
