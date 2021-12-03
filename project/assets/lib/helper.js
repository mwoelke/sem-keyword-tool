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
                'domain': dataStore.state.activeDomain['@id']
            };
            //post object
            api.apiPostKeywordGroup(keywordGroup).then(() => dataStore.loadKeywordGroups());
        } else {
            alert('Invalid length');
        }
    }
}