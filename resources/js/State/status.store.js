import {defineStore} from "pinia";

export const useStatusStore = defineStore('status', {
    state: () => ({
        isMenuOpen: false
    }),
    actions: {
        setIsMenuOpen(newValue) {
            console.log(newValue)
            this.isMenuOpen = newValue;
        }
    },
});
