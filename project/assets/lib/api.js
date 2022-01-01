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
     * @param {object} keywordGroup 
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
    apiGetAllKeywordsForDomain(domainId, pageId) {
        return axios.get("/api/keywords?page=" + pageId + "&domain.id=" + domainId)
            .then((response) => response.data["hydra:member"]);
    },

    /**
     * 
     * @param {number} groupId
     * @param {number} page 
     * @returns {Promise} Promise
     */
    apiGetAllKeywordsForKeywordGroup(groupId, page) {
        return axios.get("/api/keywords?page=" + page + "&keywordGroups.id=" + groupId)
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
    },

    /**
     * Update given Keyword 
     * @param {number} keywordId
     * @param {object} update
     * @returns 
     */
    apiPutKeyword(keywordId, update) {
        return axios.put("/api/keywords/" + keywordId, update);
    },

    /**
     * Shamelessly ripped from https://stackoverflow.com/questions/41938718/how-to-download-files-using-axios
     * @param {string} url 
     * @param {string} filename 
     * @returns 
     */
    apiDownloadFile(url, filename) {
        return axios({url, method: 'GET', responseType: 'blob'}).then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', filename); //or any other extension
            document.body.appendChild(link);
            link.click();
        });
    },

    /**
     * Post new assignment rule
     * @param {object} assignmentRule 
     * @returns 
     */
    apiPostRule(assignmentRule) {
        return axios.post("/api/assignment_rules", assignmentRule);
    },

    /**
     * Delete assignment rule
     * @param {number} assignmentRuleId 
     * @returns 
     */
    apiDeleteRule(assignmentRuleId) {
        return axios.delete("api/assignment_rules/" + assignmentRuleId);
    }
};