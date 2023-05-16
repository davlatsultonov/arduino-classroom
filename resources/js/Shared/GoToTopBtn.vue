<template>
    <button class="go-to-top-btn rounded" ref="buttonRef" @click="scrollToTop" :class="{ show: showButton }">
        Go to Top
    </button>
</template>

<script>
export default {
    data() {
        return {
            showButton: false
        };
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll);
    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        handleScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            this.showButton = scrollTop > 0;
        },
        scrollToTop() {
            const buttonRef = this.$refs.buttonRef;
            buttonRef.style.pointerEvents = 'none';
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            setTimeout(() => {
                buttonRef.style.pointerEvents = 'auto';
            }, 500);
        }
    }
};
</script>

<style scoped lang="scss">
.go-to-top-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 10px 15px;
    border: none;
    background-color: #333;
    color: #fff;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.3s;

    &:active {
        transform: scale(0.95);
    }
}

.go-to-top-btn.show {
    opacity: 1;
}
</style>
