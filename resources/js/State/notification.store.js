import {defineStore} from "pinia";

export const useNotificationStore = defineStore('notification', {
    state: () => ({
        notifications: []
    }),
    actions: {
        pushNotification(newValue) {
            if (newValue){
                const notificationId = newValue.id;
                this.notifications = [...this.notifications, newValue];

                setTimeout(() => {
                    this.removeNotification(notificationId);
                }, 4000);
            }
        },
        removeNotification(id) {
            this.notifications = this.notifications.filter(notification => notification.id !== id);
            console.log('Notification removed:', this.notifications);
        }
    },
});
