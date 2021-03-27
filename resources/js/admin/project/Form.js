import AppForm from "../app-components/Form/AppForm";

Vue.component("project-form", {
    mixins: [AppForm],
    props: ["users"],
    data: function() {
        return {
            form: {
                leader: "",
                name: "",
                description: ""
            }
        };
    }
});
