class DataStore {

  constructor() {
    // create datastores
    this.localFiles = [];
    this.localMessage = {};
  }

  getRequest(subscriber) {
    if (subscriber.request) return this[subscriber.request](subscriber.parameters);
  }

  setRequest(request) {
    // adds 'set' to request eg 'setLocalData'
    let req = 'set' + request.newInfo;
    let res = this[req](request.data);
    return res;
  }

  getMessage() {
    return this.localMessage;
  }
  setMessage(data) {
    this.localMessage = data;
  }

  getLocalData() {
    return this.localFiles;
  }

  setLocalData(data) {
    this.localFiles = data;
  }

  getRequestServerData() {
    // async handled by fetchData
  }
  setRequestServerData() {
    // async handled by fetchData
  }

  setSendLocalData() {
    // async handled by sendData
  }

  setServerResult(data) {
    let index = this.localFiles.findIndex(file => file.filepath == data.filepath);
    this.localFiles[index] = data;
  }

  getServerDataResponse() {
    // async handled by sendData
  }
  setRowChanged(data) {
    this.localFiles.filter(file => (file.filepath == data.filepath)).process_video = data.process_video;
  }
}

export default new DataStore();