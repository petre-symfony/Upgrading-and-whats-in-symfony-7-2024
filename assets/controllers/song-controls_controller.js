import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
  static values = {
    infoUrl: String
  }

  play(event) {
    event.preventDefault();

    fetch(this.infoUrlValue)
      .then((response) => {
        console.log(response)
        const audio = new Audio(response.data.url);
        audio.play();
      });
  }
}
