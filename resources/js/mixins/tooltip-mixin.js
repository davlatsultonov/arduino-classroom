import {Tooltip} from "bootstrap";

export default {
    data() {
        return {
            mobileWidth: 992
        }
    },
    mounted() {
        if (window.innerWidth > this.mobileWidth) {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
           [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))
        }
    },
    methods: {
        handleTooltipDispose() {
            if (window.innerWidth < this.mobileWidth) return;

            document.querySelectorAll('.tooltip').forEach(child => child.remove());
        }
    }
}
