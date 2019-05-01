import DataStore from './datastore.js';

class PubSub {
  constructor() {
    this.datastore = DataStore;
    this.subscribers = [];
  }

  subscribe(newInfo, request, parameters, callback) {
    this.subscribers.push({
      newInfo,
      request,
      parameters,
      callback
    });
  }

  unsubscribe(newInfo, request, parameters, callback){
    // return all subscribers who do NOT have this specific signature ie newInfo/request/callback
    this.subscribers = this.subscribers.filter(subscriber => !(subscriber.newInfo == newInfo && subscriber.request == request && subscriber.callback == callback))
  }

  publish(newInfo, data) {
    // publish the new/changed data
    this.datastore.setRequest({
      newInfo,
      data
    });
    // alert all susbscribers to new/changed data
    this.subscribers.filter(subscriber => (subscriber.newInfo == newInfo)).forEach((subscriber) => {
      subscriber.callback(this.datastore.getRequest(subscriber));
    });
  }

  // for ad hoc component requests for info eg record count
  getData(componentRequest, data) {
    return this.datastore.getRequest({
      componentRequest,
      data
    });
  }
}

export default new PubSub();