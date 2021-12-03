import axios from 'axios'
export default {
    /**
     * Get keyword groups for domain with given name
     * @param {number} domainId 
     * @returns {Promise} Promise
     */
    apiGetKeywordGroupsForDomain(domainId) {
        return axios.get(`/api/keyword_groups?domain.id=${domainId}`)
            .then((response) => response.data["hydra:member"]);
    },

    /**
     * Post new keyword group
     * @param {String} keywordGroupName 
     * @returns {Promise} Promise
     */
    apiPostKeywordGroup(keywordGroup) {
        return axios.post('/api/keyword_groups', keywordGroup);
    },

    /**
     * Get all domains 
     * @returns {Promise} Promise
     */
    apiGetAllDomains() {
        return axios.get("/api/domains")
            .then((response) => response.data["hydra:member"]);
    },

    /**
     * Post new domain
     * @param {String} domainName 
     * @returns {Promise} Promise
     */
    apiPostAddNewDomain(domainName) {
        return axios.post("/api/domains", { domainName });
    },

    apiPostKeyword(keyword) {
        console.log(keyword);
        return axios.post("/api/keywords", keyword);
    }
};