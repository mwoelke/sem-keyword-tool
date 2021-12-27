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
     * Add new Keyword
     * @param {object} keyword 
     * @returns 
     */
    apiPostKeyword(keyword) {
        return axios.post("/api/keywords", keyword);
    },

    /**
     * @param {number} domain 
     * @param {number} pageId 
     * @returns {Promise} Promise
     */
    apiGetAllKeywordsForDomain(domain, pageId) {
        return axios.get("/api/keywords?page=" + page + "&domain.id=" + pageId)
            .then((response) => response.data["hydra:member"]);
    },

    /**
     * 
     * @param {number} groupId
     * @param {number} page 
     * @returns {Promise} Promise
     */
    apiGetAllKeywordsForKeywordGroup(groupId, page) {
        return axios.get("/api/keywords?page=" + page + "&keyword_group.id= " + groupId)
            .then((response) => response.data["hydra:member"]);
    },

    /**
     * @param {number} keywordId 
     * @returns {Promise} Promise
     */
    apiGetKeyword(keywordId) {
        return axios.get("/api/keywords/" + keywordId)
            .then((response) => response.data);
    },

    /**
     * Get first unsorted keyword for given domain 
     * @param {number} domainId 
     * @returns 
     */
    apiGetFirstUnsortedKeywordForDomain(domainId) {
        return axios.get("/api/domains/" + domainId + "?get_unsorted_keyword")
            .then((response) => response.data.firstUnsortedKeyword.id);
    },

    /**
     * Lock given keyword
     * @param {number} keywordId 
     * @returns 
     */
    apiLockKeyword(keywordId) {
        return axios.put("/api/keywords/" + keywordId, {lockedAt: new Date()})
    }
};