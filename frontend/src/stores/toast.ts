import { defineStore } from 'pinia';
import { ref } from 'vue';
import type { Toast } from '@/types/toast';

export const useToastStore = defineStore('toast', () => {
    const toasts = ref<Toast[]>([]);

    const addToast = (toast: Toast) => {
        toasts.value.push({ ...toast });
    };

    const removeToast = (index: number) => {
        toasts.value.splice(index, 1);
    };

    return {
        toasts,
        addToast,
        removeToast,
    };
});
