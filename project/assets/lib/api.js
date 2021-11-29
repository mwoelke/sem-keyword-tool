import axios from 'axios'
export default {
    /**
     * Get keyword groups for domain with given name
     * @param {String} domainName 
     * @returns {Promise} Promise
     */
    apiGetKeywordGroupsForDomain(domainName) {
        return promise = axios.get("/api/keywordGroups?name=" + domainName)
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
     * Get all domains with given page
     * @param {number} page 
     * @returns {Promise} Promise
     */
    apiGetAllDomains(page) {
        return axios.get("/api/domains?page=" + page)
            .then((response) => response.data["hydra:member"]);
    },

    /**
     * Post new domain
     * @param {String} domainName 
     * @returns {Promise} Promise
     */
    apiPostAddNewDomain(domainName) {
        return axios.post("/api/domains", { domainName });
    }
};