export default {
    computed: {
        stringUpperFirstLetter: function () {
            return function (str) {
                if (str.length <= 1) return '';

                return str[0].toUpperCase() + str.slice(1)
            }
        }
    }
}
