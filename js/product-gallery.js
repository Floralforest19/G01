const current = document.querySelector("#current");
const imgs = document.querySelector(".imgs");
const img = document.querySelectorAll(".imgs img");

img.forEach((img) =>
  img.addEventListener("click", (e) => (current.src = e.target.src))
);
