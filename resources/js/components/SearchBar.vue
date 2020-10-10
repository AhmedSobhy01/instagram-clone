<template>
    <div>
        <div class="loadingio-spinner-rolling-0tu00tw3hyi" v-show="this.busy">
            <div class="ldio-904g46jbyyt">
                <div></div>
            </div>
        </div>

        <input
            class="search-bar border rounded text-center outline-none py-1 pl-4 pr-3"
            type="text"
            style="width: 250px"
            :placeholder="placeholder"
            v-model="q"
            @focus="handleFocus"
            @blur="handleBlur"
        />

        <div v-if="showSearchResults">
            <ul class="list-group search-results">
                <!-- No Results -->
                <li
                    class="list-group-item p-2 d-flex align-items-center justify-content-center"
                    v-if="noResult"
                >
                    <div class="h5 m-0 py-2">No results found</div>
                </li>

                <!-- Results -->
                <li>
                    <a
                        :href="item.profileUrl"
                        v-for="item in data"
                        :key="item.username"
                    >
                        <li
                            class="list-group-item p-2 d-flex align-items-center"
                        >
                            <div>
                                <img
                                    :src="item.profile_image"
                                    alt=""
                                    style="width: 25px"
                                />
                            </div>
                            <div class="ml-3">
                                <div class="search-results-username">
                                    {{ item.username }}
                                </div>
                                <div class="search-results-name">
                                    {{ item.name }}
                                </div>
                            </div>
                        </li>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: ["placeholder", "postTo"],

    data: function() {
        return {
            q: "",
            data: [],
            showSearchResults: false,
            noResult: false,
            searchTimeout: null,
            showSearchResultsTimeout: null,
            busy: false
        };
    },

    watch: {
        q: function() {
            if (this.q == "") {
                this.showSearchResults = false;
                this.data = [];
            } else {
                this.showSearchResults = true;
                this.doSearch();
            }
        }
    },

    methods: {
        doSearch() {
            this.busy = true;
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                axios
                    .post(this.postTo, {
                        q: this.q
                    })
                    .then(res => res.data)
                    .then(data => {
                        this.data = data.data;

                        if (this.data.length < 1 && this.q !== "") {
                            this.noResult = true;
                        } else {
                            this.noResult = false;
                        }
                    })
                    .catch(err => (this.noResult = true))
                    .finally(() => {
                        this.busy = false;
                    });
            }, 700);
        },
        handleFocus() {
            clearTimeout(this.showSearchResultsTimeout);
            if (this.q == "") {
                this.showSearchResults = false;
            } else {
                this.showSearchResults = true;
            }
        },
        handleBlur() {
            clearTimeout(this.showSearchResultsTimeout);
            this.showSearchResultsTimeout = setTimeout(() => {
                this.showSearchResults = false;
            }, 150);
        }
    }
};
</script>
