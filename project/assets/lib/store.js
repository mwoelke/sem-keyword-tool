import api from './api'

export default {
    data: {
        debug: true,
        state: {
            activeDomain: null,
            keywordGroups: null
        },
        domains: {
            page: 1,
            data: {}
        },
        async loadDomains(page) {
            this.domains.page = page,
            this.domains.data = await api.apiGetAllDomains(page)
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
        getKeywordGroups() {
            if (this.activeDomain === null) {
                throw "activeDomain is not set, can't get keyword groups";
            }
            if (this.state.keywordGroups === null) {
                this.state.keywordGroups = api.apiGetKeywordGroupsForDomain(this.activeDomain.name)
            }
            return this.state.keywordGroups;
        }
    }
}