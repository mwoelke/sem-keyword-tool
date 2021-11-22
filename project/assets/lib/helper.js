//put a whole object in LocalStorage
Storage.prototype.setObject = function(key, value) {
    this.setItem(key, JSON.stringify(value));
}
//get a whole object from LocalStorage
Storage.prototype.getObject = function(key) {
    var value = this.getItem(key);
    //this will return 'null' if getItem returned null, otherwise will return the object. Nifty.
    return value && JSON.parse(value);
}