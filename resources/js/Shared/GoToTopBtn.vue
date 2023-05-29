<template>
    <button class="go-to-top-btn btn-outline-dark rounded" ref="buttonRef" @click="scrollToTop" :class="{ show: showButton }">
        Ба аввали саҳифа
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
        // Добавляет слушатель события прокрутки страницы
        window.addEventListener('scroll', this.handleScroll);
    },
    beforeUnmount() {
        // Удаляет слушатель события прокрутки страницы перед удалением компонента
        window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        // Обрабатывает событие прокрутки страницы
        handleScroll() {
            // Получаем значение вертикальной прокрутки страницы
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            // Устанавливаем значение переменной showButton в зависимости от значения прокрутки
            this.showButton = scrollTop > 0;
        },
        // Прокручивает страницу вверх
        scrollToTop() {
            // Получаем ссылку на элемент кнопки
            const buttonRef = this.$refs.buttonRef;
            // Отключаем возможность взаимодействия с кнопкой
            buttonRef.style.pointerEvents = 'none';
            // Прокручиваем страницу вверх с плавной анимацией
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            // Включаем возможность взаимодействия с кнопкой через 500 миллисекунд
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
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.3s;
    z-index: 500;

    &:active {
        transform: scale(0.95);
    }
}

.go-to-top-btn.show {
    opacity: 1;
}
</style>
