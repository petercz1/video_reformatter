import PubSub from '../data/pubsub.js';
import AppTableRow from './app-tablerow.js';

export default class AppTableBase extends RootElement {
  constructor() {
    super();
    this.pubsub = PubSub;
    this.renderData = this.renderData.bind(this);
    this.pubsub.subscribe('FileChecked', 'updateFiles', null, this.renderData);
    this.pubsub.subscribe('LocalData', 'getLocalData', null, this.renderData);
    this.pubsub.subscribe('ServerResult', 'getLocalData', null, this.renderData);
  }

  renderData(data) {
    //check for any server errors
    if (data.error) {
      console.log(data);
    }

    // build table structure
    this.setAttribute('class', 'basictable');
    this.innerHTML = `
      <div class="theader">
          <div class="trow center">
            <div class="theadercell">file name</div>
            <div class="theadercell">extension</div>
            <div class="theadercell">video format</div>
            <div class="theadercell">audio format</div>
            <div class="theadercell">brand</div>
            <div class="theadercell">process?</div>
          </div>
        </div>
      <div class="tbody" id="tableBase"></div>
      <div class="tfooter">
        <!-- footer stuff in here -->
      </div>
        `;

    // loop through rows
    data.forEach(file => {
      this.querySelector('.tbody').append(new AppTableRow(file));
    });
  }
}

customElements.define('app-tablebase', AppTableBase);