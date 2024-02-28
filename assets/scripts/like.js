import axios from "axios";
export default class Like {
  constructor(likeElements) {
    this.likeElements = likeElements;
    if (likeElements) {
      this.init();
    }
  }
  init() {
    this.likeElements.map((element) => {
      element.addEventListener("click", this.likeClicked);
    });
  }
  likeClicked(e) {
    e.preventDefault();
    const url = this.href;
    axios.get(url).then((rep) => {
      const nbLikes = rep.data.nbLikes;
      console.log(this.querySelector("img"));
      const span = this.querySelector("span");
      this.dataset.nbLikes = nbLikes;
      span.innerHTML = nbLikes > 1 ? nbLikes + " J'aimes" : nbLikes + " J'aime";

      const imgFilled = this.querySelector("img.filled");
      const imgUnFilled = this.querySelector("img.unFilled");

      imgFilled.classList.toggle("hidden");
      imgUnFilled.classList.toggle("hidden");
    });
  }
}
