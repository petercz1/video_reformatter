import PubSub from '../data/pubsub.js';


export default class AppTableRow extends HTMLElement {
  constructor(file) {
    super();
    this.pubsub = PubSub;
    this.file = file;
    this.renderData = this.renderData.bind(this);
    this.registerChange = this.registerChange.bind(this);
    this.renderData();
  }
  renderData() {
    this.setAttribute('class', 'trow');
    this.innerHTML = `
		<div class="tcell">${this.file.filename}</div>
		<div class="tcell">${this.file.extension}</div>
		<div class="tcell">${this.file.videoFormat}</div>
		<div class="tcell">${this.file.audioFormat}</div>
    <div class="tcell">${this.file.mp41 ? 'mp41' : 'not mp41'}</div>
    <div class="tcell center select"></div>
		`;
    if ((this.file.videoFormat == 'AVC' && this.file.audioFormat == 'AAC' && this.file.mp41) || this.file.processed == true) {
      this.querySelector('.select').innerHTML = `<span class="completed">done: ${()=>{if(this.file.timer) /media/pc/64GB USB/videos/films/me}}</span>`;
    }else{
      this.querySelector('.select').innerHTML = `<input class="form-check-input video-delete" type="checkbox" id="${this.file.filepath}" value="chekit">`;
      this.querySelector('input').checked = this.file.process_video;
      this.querySelector('input').addEventListener('change', this.registerChange);
    }
  }

  registerChange() {
    // publish change to status of person
    this.file.process_video = !this.file.process_video;
    this.pubsub.publish('RowChanged', this.file);
  }
}
customElements.define('app-tablerow', AppTableRow);