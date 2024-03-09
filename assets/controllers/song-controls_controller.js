import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
  static values = {
    infoUrl: String
  }

  async play(event) {
    event.preventDefault();

    const response = await fetch(this.infoUrlValue)
    console.log(response)
    const audio = new Audio(response.data.url)
    audio.play()
  }
}
