// Set up the canvas and context
var canvas = document.getElementById("canvas");
canvas.width = window.innerWidth-20;
canvas.height = window.innerHeight-20;

var ctx = canvas.getContext("2d");

const ACCELERATION = 1; // The acceleration factor
const EASING = 0.2; // The easing factor
const MAX_SPEED = 7; // The maximum speed of the paddle

let paddleVelocity = 0; // The current velocity of the paddle

let playerScore = 0;
let computerScore = 0;

let loopIntervalId=null;
let start_time = Date.now()   ;




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
  ctx.fillStyle = "white";
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
    playerPaddle.y -= playerPaddle.dy*paddleVelocity;
  }
}

// Move the player paddle down
function movePlayerDown() {
    paddleVelocity = paddleVelocity + ACCELERATION;  
    paddleVelocity = Math.min(paddleVelocity, MAX_SPEED);
  if (playerPaddle.y + playerPaddle.height < canvas.height) {
    playerPaddle.y += playerPaddle.dy*paddleVelocity;
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
  }
}

// Check for collision between the ball and the top or bottom of the canvas
function checkCanvasCollision() {
  if (ball.y + ball.dy < ball.radius || ball.y + ball.dy > canvas.height - ball.radius) {
    ball.dy = -ball.dy;
  }
}

// Update the position of the ball
function updateBall() {
    ball.x += ball.dx;
    ball.y += ball.dy;

    
    }
    
    // Update the position of the computer paddle
    function updateComputerPaddle() {
    moveComputerPaddle();
    }
    
    // Clear the canvas and draw all game elements
    function draw() {
    // Clear the canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    

    //Draw timer
    drawTimer();

    //Draw centerline
    drawDashedLine();

    // Draw the ball
    drawBall();
    
    // Draw the player paddle
    drawPlayerPaddle();
    
    // Draw the computer paddle
    drawComputerPaddle();
    }

     // Check for a win condition
    function checkWinCondition() {
        if (ball.x < 0) {
          computerScore++;
          updateScoreboard();
          resetGame();
        } else if (ball.x > canvas.width) {
          playerScore++;
          updateScoreboard();
          resetGame();
        }
      }
      
      function updateScoreboard() {
        document.getElementById("player-score").innerHTML = "Player:" + playerScore;
        document.getElementById("computer-score").innerHTML = "Computer: "+ computerScore;
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
      
    
    // Update the game state and redraw the canvas
    function update() {
     
    updateBall();
    checkCanvasCollision();
    checkCollision(playerPaddle);
    checkCollision(computerPaddle);
    checkWinCondition();
    updateComputerPaddle();
   
    draw();
    }
    
    // Set up the event listeners for player input
    document.addEventListener("keydown", function(event) {
    
     event.preventDefault();  //prevent moving the browser window

    if (event.code === "ArrowUp") {
    movePlayerUp();
    } else if (event.code === "ArrowDown") {
    movePlayerDown();
    }
     else if (event.code === "Space") {
        intermissionTimer(3);
    }
    });

    function drawTimer() {

        let gameTime=Date.now() - start_time;
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
            // Otherwise, start the game loop
            gameLoop();
          }
        },  1000);
      }
      

    function resetGame() {


        clearInterval(loopIntervalId);  //stop the game loop
        ball.x = canvas.width / 2;
        ball.y = canvas.height / 2;
        ball.dx = 5;
        ball.dy = 5;
      
        playerPaddle.y = canvas.height / 2 - 50;
        computerPaddle.y = canvas.height / 2 - 50;
        paddleVelocity=0;
          // Update the score display
        // playerScore = 0;
        // computerScore = 0;
       // Clear the canvas
     
       
    // ctx.clearRect(0, 0, canvas.width, canvas.height);
        
    ctx.font = "120px sans-serif";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    ctx.fillStyle = "#fff";
    ctx.fillText("Press Space to try again", canvas.width / 2, canvas.height / 2);
        updateScoreboard();
        drawDashedLine();
        drawTimer();
       
       
      }
      
    
    // Set up the game loop
function gameLoop() {
   loopIntervalId= setInterval(update, 10);
}

gameLoop();