<template>
    <div class="my-4" v-if="authorized">
        <div class="row">
            <div 
                class="col-xs-6 col-md-4 col-lg-3 mb-4"
                v-for="beer in beers"
                :key="beer.id">
                <Beer :item="beer" />
            </div>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item" v-if="currentPage != 1">
                    <span class="page-link" aria-label="Previous" @click="goToPage(currentPage-1)">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </span>
                </li>
                <li class="page-item" v-if="currentPage == pages && pages > 2">
                    <span class="page-link" @click="goToPage(currentPage-2)">{{ currentPage-2 }}</span>
                </li>
                <li class="page-item" v-if="currentPage != 1">
                    <span class="page-link" @click="goToPage(currentPage-1)">{{ currentPage-1 }}</span>
                </li>
                <li class="page-item active">
                    <span class="page-link" @click="goToPage(currentPage)">{{ currentPage }}</span>
                </li>
                <li class="page-item" v-if="currentPage != pages">
                    <span class="page-link" @click="goToPage(currentPage+1)">{{ currentPage+1 }}</span>
                </li>
                <li class="page-item" v-if="currentPage == 1 && pages > 2">
                    <span class="page-link" @click="goToPage(currentPage+2)">{{ currentPage+2 }}</span>
                </li>
                <li class="page-item" v-if="currentPage != pages">
                    <span class="page-link" aria-label="Next" @click="goToPage(currentPage+1)">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </span>
                </li>
            </ul>
        </nav>
    </div>
    <div class="my-5 text-center" v-else>
        <h2>Content reserved to authenticated users.</h2>
        <h3>Login <a href="/login">here</a> to see all our beers.</h3>
    </div>
</template>

<script>
import Beer from '../components/Beer';

export default {
    name: "Home",
    components: {
        Beer
    },
    data() {
        return {
            beers: [],
            authorized: true,
            pages: 28
        };
    },
    computed: {
        currentPage: function() {
            return this.$route.query.hasOwnProperty('page') ? parseInt(this.$route.query.page) : 1;
        }
    },
    mounted() {
        if(this.$route.query.hasOwnProperty('page')) {
            this.getBeers(this.$route.query.page);
        } else {
            this.getBeers();
        }
    },
    methods: {
        goToPage: function (newPage) {
            this.$router.replace({ query: { page: newPage } });
            this.getBeers(newPage);
        },
        getBeers: function(page = 1, itemsPerPage = 12) {
            const url = `/api/beers?page=${page}&per_page=${itemsPerPage}`;
            axios
                .get(url)
                .then(
                    res => {
                        this.authorized = true;
                        this.beers = res.data;
                    }
                )
                .catch(
                    error => {
                        if(error.response.status == 401) {
                            this.authorized = false;
                        }
                    }
                );
        }
    }
}
</script>

<style>
    .page-link {
        cursor: pointer;
    }
</style>