import axios from "axios";
import api from './api';
import Store from './store'

export default {
    addNewKeywordGroup: function(dataStore) {
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
            api.apiPostKeywordGroup(keywordGroup).then(() => dataStore.getKeywordGroups());
        } else {
            alert('Invalid length');
        }
        //location.reload();
    }
}

//add new keyword through prompt
    window.updateKeywordGroups = function () {
        axios.get('/api/keyword_groups?domain.id=' + localStorage.getObject('activeDomain').id).then(function (response) {
            if (response["hydra:member"] === undefined) {
                response["hydra:member"] = {}
            }
            localStorage.setObject("activeDomainKeywordGroups", response["hydra:member"]);
        })
    }