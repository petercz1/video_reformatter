import RootElement from './app-rootelement.js';
import PubSub from '../data/pubsub.js';

export default class AppControlButton extends RootElement {

  constructor() {
    super();
    this.pubsub = PubSub;

    // subscribe to 'ReturnedServerData' event
    this.pubsub.subscribe('LocalData', null, null, this.processData);
    this.pubsub.subscribe('Message', 'getMessage', null, this.processData);
    // do initial render
    this.renderData();
  }

  renderData() {
    this.innerHTML = `
    <button class="btn btn-primary" id="processVideos">Get videos</button>
    <div class="warning"></div>
    `;
    // if clicked, publish to anyone interested in 'RequestServerData'
    this.querySelector('button').addEventListener('click', () => this.pubsub.publish('RequestServerData', null));
  }

  // processData triggered if anyone publishes to 'ReturnedServerData'
  processData(data) {
    // if no error, publish a message, change button text, remove old event listener, add new one
    if (data && data.source == 'server error') {
      this.querySelector('div.warning').innerHTML = data.text;
      return
    } else {
      this.querySelector('div.warning').innerHTML = '';
    }

    // once notified of 'ReturnedServerData', unsubscribe to it so this won't get fired again
    this.pubsub.unsubscribe('ReturnedServerData', null, null, this.processData);

    this.querySelector('button').innerHTML = "process videos";
    this.querySelector('button').removeEventListener('click', () => this.pubsub.publish('RequestServerData', null));
    this.querySelector('button').addEventListener('click', () => {
      // announce 'SendLocalData' has been pressed to anyone listening
      this.pubsub.publish('SendLocalData', null);
      // change button
      this.querySelector('button').innerHTML = "processing...";
      this.querySelector('button').disabled = true;
      this.querySelector('button').classList.remove('btn-primary')
      this.querySelector('button').classList.add('btn-secondary');
    });

  }
}

customElements.define('app-controlbutton', AppControlButton);