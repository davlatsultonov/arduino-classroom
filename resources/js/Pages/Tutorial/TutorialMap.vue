<template>
    <div class="modal fade" id="tutorial-map" tabindex="-1" aria-labelledby="tutorial-map" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header shadow-sm">
                    <div class="container d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">
                            <img src="/images/close-icon.svg" width="15" alt="close icon">
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <TutorialsList :tutorials="$page.props.shared.tutorials"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TutorialsList from "./TutorialsList.vue";

export default {
    name: "TutorialMap",
    components: {TutorialsList}
}
</script>

<style scoped lang="scss">
.modal-header {
    z-index: 500;
}
</style>
