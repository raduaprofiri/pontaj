import AppListing from '../app-components/Listing/AppListing';

Vue.component('timekeeping-listing', {
    mixins: [AppListing],
    props: ['projects', 'users']
});