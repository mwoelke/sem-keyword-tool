import axios from "axios";

//put a whole object in LocalStorage
Storage.prototype.setObject = function (key, value) {
    this.setItem(key, JSON.stringify(value));
}
//get a whole object from LocalStorage
Storage.prototype.getObject = function (key) {
    var value = this.getItem(key);
    //this will return 'null' if getItem returned null, otherwise will return the object. Nifty.
    return value && JSON.parse(value);
}

//add new keyword, used on two buttons so I moved it here
window.addNewKeywordGroup = function () {
    //ask for group name
    let keywordGroupName = prompt('Enter name');
    //check if valid length
    if (keywordGroupName.length >= 1 && keywordGroupName.length <= 255) {
        //create object for post
        let keywordGroup = {
            'name': keywordGroupName,
            'domain': localStorage.getObject("activeDomain")["@id"]
        };
        //post object
        axios.post('/api/keyword_groups', keywordGroup).then(function (result) {
            window.updateKeywordGroups();
        });
    } else {
        alert('Invalid length');
    }
    //location.reload();
}

window.updateKeywordGroups = function() {
    axios.get('/api/keyword_groups?domain.id=' + localStorage.getObject('activeDomain').id).then(function(response) {
        if(response["hydra:member"] === undefined) {
            response["hydra:member"] = {}
        }
        localStorage.setObject("activeDomainKeywordGroups", response["hydra:member"]);
    })
}