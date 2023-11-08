// Set up the canvas and context
var canvas = document.getElementById("canvas");
canvas.width = window.innerWidth - 20;
canvas.height = window.innerHeight - 20;

var ctx = canvas.getContext("2d");


const ACCELERATION = 2; // The acceleration factor
const EASING = 0.2; // The easing factor
const MAX_SPEED = 7; // The maximum speed of the paddle
const BALL_MOVMENT_SPEED = 3; //affects how fast the ball moves
let ball_hits = 0   //counts how many times ball hits racket 
const BALL_HITS_THRESHOLD = 3  //after this many ball hits increase game cadence.

let ball_color = "white";  //change color to show speed increase
let paddleVelocity = 0; // The current velocity of the paddle

let playerScore = 0;
let computerScore = 0;

let loopIntervalId = null;
let start_time = Date.now();




// Set up the ball
var ball = {
  x: canvas.width / 2,
  y: canvas.height / 2,
  radius: 10,
  dx: 5,
  dy: -5
};

// Set up the player paddle
var playerPaddle = {
  x: 10,
  y: canvas.height / 2 - 40,
  width: 10,
  height: 80,
  dy: 5
};

// Set up the computer paddle
var computerPaddle = {
  x: canvas.width - 20,
  y: canvas.height / 2 - 40,
  width: 10,
  height: 80,
  dy: 5
};

// Draw the ball on the canvas
function drawBall() {
  ctx.beginPath();
  ctx.arc(ball.x, ball.y, ball.radius, 0, Math.PI * 2);
  ctx.fillStyle = ball_color;
  ctx.fill();
  ctx.closePath();
}

// Draw the player paddle on the canvas
function drawPlayerPaddle() {
  ctx.beginPath();
  ctx.rect(playerPaddle.x, playerPaddle.y, playerPaddle.width, playerPaddle.height);
  ctx.fillStyle = "white";
  ctx.fill();
  ctx.closePath();
}

// Draw the computer paddle on the canvas
function drawComputerPaddle() {
  ctx.beginPath();
  ctx.rect(computerPaddle.x, computerPaddle.y, computerPaddle.width, computerPaddle.height);
  ctx.fillStyle = "white";
  ctx.fill();
  ctx.closePath();
}

// Move the player paddle up
function movePlayerUp() {

  paddleVelocity = paddleVelocity + ACCELERATION;
  paddleVelocity = Math.min(paddleVelocity, MAX_SPEED);
  if (playerPaddle.y > 0) {
    playerPaddle.y -= playerPaddle.dy * paddleVelocity;
  }
}

// Move the player paddle down
function movePlayerDown() {
  paddleVelocity = paddleVelocity + ACCELERATION;
  paddleVelocity = Math.min(paddleVelocity, MAX_SPEED);
  if (playerPaddle.y + playerPaddle.height < canvas.height) {
    playerPaddle.y += playerPaddle.dy * paddleVelocity;
  }
}

// Move the computer paddle towards the ball
function moveComputerPaddle() {
  var paddleCenter = computerPaddle.y + (computerPaddle.height / 2);
  if (paddleCenter < ball.y) {
    computerPaddle.y += computerPaddle.dy;
  } else {
    computerPaddle.y -= computerPaddle.dy;
  }
}

// Check for collision between the ball and a paddle
function checkCollision(paddle) {
  if (ball.x + ball.radius > paddle.x &&
    ball.x - ball.radius < paddle.x + paddle.width &&
    ball.y + ball.radius > paddle.y &&
    ball.y - ball.radius < paddle.y + paddle.height) {
    ball.dx = -ball.dx;
    ball_hits++;  //count how many times the balls collided with paddle

  }
}

// Check for collision between the ball and the top or bottom of the canvas
function checkCanvasCollision() {
  if (ball.y + ball.dy < ball.radius || ball.y + ball.dy > canvas.height - ball.radius) {
    ball.dy = -ball.dy;  //change directions
  }
}

// Update the position of the ball
function updateBall() {

  let speedup = 0;
  //adjust the movement factor after x hits
  if (ball_hits > BALL_HITS_THRESHOLD) {
    speedup = BALL_MOVMENT_SPEED;
    ball_color = "cyan";  //indicate sped up ball
  }

  ball.x += ball.dx + speedup;
  ball.y += ball.dy + speedup;


}

// Update the position of the computer paddle
function updateComputerPaddle() {
  moveComputerPaddle();
}



// Check for a win condition
function checkWinCondition() {
  if (ball.x < 0) {
    computerScore++;
    resetGame();
    updateScoreboard();

  } else if (ball.x > canvas.width) {
    playerScore++;
    resetGame();
    updateScoreboard();

  }


}

function resetGame() {


  clearInterval(loopIntervalId);  //stop the game loop

  ball.x = canvas.width / 2;
  ball.y = canvas.height / 2;
  ball.dx = 5;
  ball.dy = 5;

  playerPaddle.y = canvas.height / 2 - 50;
  computerPaddle.y = canvas.height / 2 - 50;
  paddleVelocity = 0;
  ball_hits = 0;
  ball_color = "white";

  drawMessage("Press Space to continue");

}

function updateScoreboard() {
  document.getElementById("player-score").innerHTML = "Player:" + playerScore;
  document.getElementById("computer-score").innerHTML = "Computer: " + computerScore;
  //console.log("Player: "+playerScore+ "  Computer: "+computerScore);
}

function drawDashedLine() {
  // Set the line properties
  ctx.strokeStyle = "#fff";
  ctx.lineWidth = 5;
  ctx.setLineDash([20, 20]); // Set the dash pattern

  // Draw the dashed line
  ctx.beginPath();
  ctx.moveTo(canvas.width / 2, 0);
  ctx.lineTo(canvas.width / 2, canvas.height);
  ctx.stroke();

  // Reset the line dash pattern
  ctx.setLineDash([]);
}


// Main loop funciton Update the game state and redraw the canvas
function update() {

  updateBall();
  checkCanvasCollision();
  checkCollision(playerPaddle);
  checkCollision(computerPaddle);
  checkWinCondition();
  updateComputerPaddle();

  draw();
}

// Clear the canvas and draw all game elements
function draw() {
  // Clear the canvas
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  drawTimer();  //Draw timer
  drawDashedLine();  //Draw centerline
  drawBall();    // Draw the ball
  drawPlayerPaddle();   // Draw the player paddle
  drawComputerPaddle();  // Draw the computer paddle
}

// Set up the event listeners for player input
document.addEventListener("keydown", function (event) {

  event.preventDefault();  //prevent moving the browser window

  if (event.code === "ArrowUp" || event.code === "ArrowLeft") {
    movePlayerUp();
  } else if (event.code === "ArrowDown" | event.code === "ArrowRight") {
    movePlayerDown();
  }
  else if (event.code === "Space") {

    intermissionTimer(2);
  }
});

function drawTimer() {

  let gameTime = Date.now() - start_time;
  // Set the timer properties
  ctx.font = "48px sans-serif";
  ctx.fillStyle = "#fff";
  ctx.strokeStyle = "#000";
  ctx.lineWidth = 5;
  ctx.textAlign = "center";

  // Calculate the minutes and seconds from the game time in milliseconds
  let minutes = Math.floor(gameTime / 60000);
  let seconds = Math.floor((gameTime % 60000) / 1000);

  // Add leading zeroes to the seconds if needed
  if (seconds < 10) {
    seconds = "0" + seconds;
  }

  // Draw the timer text in minutes:seconds format at the top center of the screen
  // Draw the timer text in minutes:seconds format with a black border
  ctx.strokeText(`${minutes}:${seconds}`, canvas.width / 2, 50);
  ctx.fillText(`${minutes}:${seconds}`, canvas.width / 2, 50);
}

function intermissionTimer(count) {
  // Clear the canvas
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Draw the countdown number in the center of the screen
  ctx.font = "bold 200px sans-serif";
  ctx.textAlign = "center";
  ctx.textBaseline = "middle";
  ctx.fillStyle = "#fff";
  ctx.fillText(count, canvas.width / 2, canvas.height / 2);

  // Wait for 1 second before decrementing the count
  setTimeout(() => {
    // Decrement the count
    count--;

    // If the count is greater than 0, call the intermissionTimer() function again
    if (count > 0) {
      requestAnimationFrame(() => intermissionTimer(count));
    } else {

      gameLoop();   // start the game loop
    }
  }, 1000);
}


function drawMessage(message) {
 
  const canvasWidth = canvas.width;
  const canvasHeight = canvas.height;

  // Center the text

  ctx.font = '36px Arial';
  const textX = (canvasWidth - ctx.measureText(message).width) / 2;
  const textY = canvasHeight / 2;

  // Get the center of the canvas
  const centerX = textX + ctx.measureText(message).width / 2;
  const centerY = textY - 15;

  // Draw the rectangle
  const width = ctx.measureText(message).width + 40;
  const height = 90;
  const outlineWidth = 5;

  // Draw the rectangle outline
  ctx.strokeStyle = '#FFFFFF';
  ctx.lineWidth = outlineWidth;
  ctx.strokeRect(centerX - width / 2, centerY - height / 2, width, height);

  // Fill the rectangle with black
  ctx.fillStyle = '#000000';
  ctx.fillRect(centerX - width / 2 + outlineWidth / 2, centerY - height / 2 + outlineWidth / 2, width - outlineWidth, height - outlineWidth);

  // Draw the text in white
  ctx.fillStyle = '#FFFFFF';
  ctx.fillText(message, textX, textY);

}




// Set up the game loop
function gameLoop() {
  loopIntervalId = setInterval(update, 15);  //update game state every 10ms
}

drawMessage("Press SPACE to Start, arrow keys move");
if (event.code === "Space")
  gameLoop(); //start the game 
