import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
  static values = {
    infoUrl: String
  }

  async play(event) {
    event.preventDefault();

    const response = await fetch(this.infoUrlValue)
    const data = await response.json()
    const audio = new Audio(data.url)
    audio.play()
  }
}
