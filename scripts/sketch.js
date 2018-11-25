var targets = []; // array to hold target objects
var hit = false;
var hitframe = 0;
var hitX;
var hitY;
var offSet = 0;
var img;

function setup() {
  var canvas = createCanvas(0.8 * windowWidth, 0.9 * windowHeight);
  img = loadImage('./img/ball.png');

  // Move the canvas so it’s inside our <div id="sketch-holder">.
  canvas.parent('sketch-holder');
  fill(240);
  noStroke();
}

function draw() {
  background(208, 230, 227);
  let t = frameCount / 60; // update time

  // create a random number of targets each frame
  if (frameCount % 5 == 0) {
    targets.push(new target()); // append target object
  }

  // loop through targets with a for..of loop
  for (let flake of targets) {
    flake.update(t); // update target position
    flake.display(); // draw target
  }
  push();
  if (hit) {
    offSet++;

    if (frameCount - hitframe < 30) {
      fill(224, 0, 202);
    }
    if (frameCount - hitframe >= 30) {
      let alpha = ~~map(frameCount - hitframe, 30, 40, 255, 0);
      fill(224, 0, 202, alpha);
    }
    text('BANG', hitX, hitY - offSet);

    if (frameCount - hitframe > 40) {
      hit = false;
    }
  }
  noFill();
  strokeWeight(2);
  stroke(170, 0, 0);
  ellipse(mouseX, mouseY, 35, 35);
  line(mouseX, 0, mouseX, height);
  line(0, mouseY, width, mouseY);
  pop();
}

// target class
function target() {

  // initialize coordinates
  this.posX = 0;
  this.posY = random(-50, 0);
  this.size = random(30) + 20;
  this.initialangle = random(0, 2 * PI);
  this.angle = 0;
  this.dying = false;
  this.deathFrame;

  // radius of target spiral
  // chosen so the targets are uniformly spread out in area
  this.radius = sqrt(random(pow(width / 2, 2)));

  this.update = function(time) {
    // x position follows a circle
    let w = 0.6; // angular speed
    angle = w * time + this.initialangle;

    if (!this.dying) {
      this.posX = width / 2 + this.radius * sin(angle);

      // different size targets fall at slightly different y speeds
      this.posY += pow(this.size, 0.2);

    }

    // delete target if past end of screen
    if (this.posY > height + this.size) {
      this.die();
    }
  };

  this.display = function() {

    push();
    translate(this.posX, this.posY);
    rotate(angle * 3);

    if (this.dying) {
      let rad = map(frameCount - this.deathFrame, 0, 20, 0, this.size);

      fill(255, 0, 0);
      ellipse(0, 0, this.size, this.size);
      fill(208, 230, 227);
      ellipse(0, 0, rad, rad);

      if (frameCount - this.deathFrame > 20) {
        this.die();
      }
    } else {
      image(img, -this.size / 2, -this.size / 2, this.size, this.size);
    }
    pop();
  };

  this.die = function() {
    let index = targets.indexOf(this);
    targets.splice(index, 1);
  }
}

function mouseDragged() {
  for (let i = 0; i < targets.length; i++) {
    if (abs(targets[i].posX - mouseX) - targets[i].size < 0 &&
      abs(targets[i].posY - mouseY) - targets[i].size < 0) {

      if (!targets[i].dying) {
        targets[i].deathFrame = frameCount;
      }
      targets[i].dying = true;

      offSet = 0;
      hit = true;
      hitframe = frameCount;
      hitX = mouseX;
      hitY = mouseY;
    }
  }
}
