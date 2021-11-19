<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h1>{{ $route.params.domainName }}</h1>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                Hier stehen Dinge.
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'DomainDashboard',
    props: ['domainName'],
    data() {
        return {
            domain: [],
        }
    },
    async mounted() {
        //const response = await axios.get('/api/domain/' . );
        
    }
}
</script>