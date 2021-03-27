import AppListing from "../app-components/Listing/AppListing";

Vue.component("project-listing", {
    mixins: [AppListing],
    data() {
        return {
            showLeadersFilter: false,
            leadersMultiselect: {},

            filters: {
                leaders: []
            }
        };
    },
    watch: {
        showLeadersFilter() {
            this.leadersMultiselect = [];
        },
        leadersMultiselect(newVal, oldVal) {
            this.filters.leaders = newVal.map(object => {
                return object["key"];
            });

            this.filter("leaders", this.filters.leaders);
        }
    }
});
