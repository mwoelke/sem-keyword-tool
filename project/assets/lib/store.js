import api from './api'

export default {
    data: {
        debug: true,
        state: {
            activeDomain: null,
            keywordGroups: null
        },
        domains: {},
        async loadDomains() {
            this.domains = await api.apiGetAllDomains();
        },
        setActiveDomain(data) {
            if (this.debug) {
                console.log('setActiveDomain triggered with following data');
                console.log(data);
            }
            this.state.activeDomain = data;
            this.state.keywordGroups = null;
        },
        setKeywordGroups(data) {
            if (this.debug) {
                console.log('setKeywordGroups triggered with following data');
                console.log(data);
            }
            this.state.keywordGroups = data;
        },
        clearActiveDomain(data) {
            if (this.debug) console.log('clearActiveDomain triggered');
            this.state.activeDomain = null;
        },
        async loadKeywordGroups() {
            if (this.state.activeDomain === null) {
                throw "activeDomain is not set, can't get keyword groups";
            }
            this.setKeywordGroups(await api.apiGetKeywordGroupsForDomain(this.state.activeDomain.id));
        }
    }
}