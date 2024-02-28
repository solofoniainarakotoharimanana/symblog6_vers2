/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import "./styles/app.css";

import "tw-elements";

import { Dropdown, Ripple, initTE } from "tw-elements";
import Like from "./scripts/like";

initTE({ Dropdown, Ripple });

document.addEventListener("DOMContentLoaded", () => {
  const likeElements = [].slice.call(
    document.querySelectorAll('a[data-action="like"]')
  );
  //console.log(likeElements);
  if (likeElements) {
    new Like(likeElements);
  }
});
