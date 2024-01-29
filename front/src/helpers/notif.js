import { useToast } from 'vue-toastification'; 

const toast = useToast();

export function notify(message, type = 'info') {
    toast[type](message, {
        position: 'top-right',
        timeout: 5000,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: 'button',
        icon: true,
        rtl: false
    });
}

export function clearNotify() {
    toast.clear();
}