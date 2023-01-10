const body = document.getElementById("body");

let colorIndex = 0;
const colors = [
  "rgb(255, 0, 0)",
  "rgb(0, 255, 0)",
  "rgb(0, 0, 255)",
  "rgb(255, 255, 0)",
  "rgb(0, 255, 255)",
  "rgb(255, 0, 255)"
];

setInterval(() => {
  body.style.backgroundColor = colors[colorIndex];
  colorIndex = (colorIndex + 1) % colors.length;
}, 50);


const button = document.getElementById("myButton");

button.addEventListener("mouseover", () => {
  // Generate a random x and y position for the button
  const x = Math.random() * window.innerWidth;
  const y = Math.random() * window.innerHeight;

  // Use CSS to reposition the button
  button.style.left = `${x}px`;
  button.style.top = `${y}px`;
});

const container = document.getElementById("fallingTextContainer");
const text = "Rain";
const numOfText = 30;

button.addEventListener("mouseover", () => {
    for (let i = 0; i < numOfText; i++) {
        const textElement = document.createElement("div");
        textElement.innerText = text;
        textElement.classList.add("falling-text");
        textElement.style.animationDelay = `${i * 0.1}s`;
        container.appendChild(textElement);
    }
});
