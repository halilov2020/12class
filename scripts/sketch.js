let snowflakes = []; // array to hold snowflake objects
let hit = false;
let hitframe = 0;
let hitX;
let hitY;
let offSet = 0;

function setup() {
  var canvas = createCanvas(windowWidth, windowHeight);

  // Move the canvas so it’s inside our <div id="sketch-holder">.
  canvas.parent('sketch-holder');
  fill(240);
  noStroke();
}

function draw() {
  background(233, 84, 37);
  let t = frameCount / 60; // update time

  // create a random number of snowflakes each frame
  for (var i = 0; i < random(3); i++) {
    snowflakes.push(new snowflake()); // append snowflake object
  }

  // loop through snowflakes with a for..of loop
  for (let flake of snowflakes) {
    flake.update(t); // update snowflake position
    flake.display(); // draw snowflake
  }

  if (hit) {
    offSet++;

    if (frameCount - hitframe < 30) {
      fill(33, 237, 72);
    }
    if (frameCount - hitframe >= 30) {
      let alpha = ~~map(frameCount - hitframe, 30, 40, 255, 0);
      fill(33, 237, 72, alpha);
    }
    text('BANG', hitX, hitY - offSet);

    if (frameCount - hitframe > 40) {
      hit = false;
      offSet = 0;
    }
  }

  noFill();
  strokeWeight(2);
  stroke(170, 0, 0);
  ellipse(mouseX, mouseY, 35, 35);
  line(mouseX, 0, mouseX, height);
  line(0, mouseY, width, mouseY);
  fill(240);
  noStroke();
}

// snowflake class
function snowflake() {


  // initialize coordinates
  this.posX = 0;
  this.posY = random(-50, 0);
  this.size = random(2, 5);
  this.initialangle = random(0, 2 * PI);

  // radius of snowflake spiral
  // chosen so the snowflakes are uniformly spread out in area
  this.radius = sqrt(random(pow(width / 2, 2)));

  this.update = function(time) {
    // x position follows a circle
    let w = 0.6; // angular speed
    let angle = w * time + this.initialangle;
    this.posX = width / 2 + this.radius * sin(angle);

    // different size snowflakes fall at slightly different y speeds
    this.posY += pow(this.size, 0.5);

    // delete snowflake if past end of screen
    if (this.posY > height) {
      let index = snowflakes.indexOf(this);
      snowflakes.splice(index, 1);
    }
  };

  this.display = function() {
    ellipse(this.posX, this.posY, this.size);
  };
}

function mouseClicked() {
  for (let i = 0; i < snowflakes.length; i++) {
    if (abs(snowflakes[i].posX - mouseX) - snowflakes[i].size < 0 &&
      abs(snowflakes[i].posY - mouseY) - snowflakes[i].size < 0) {
      snowflakes.splice(i, 1);
      hit = true;
      hitframe = frameCount;
      hitX = mouseX;
      hitY = mouseY;
    }
  }
}
