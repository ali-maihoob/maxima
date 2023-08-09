import Alert from 'sweetalert2';

export const alert = {
    success(message) {
        return Alert.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
        });
    },

    error(message) {
        return Alert.fire({
            icon: 'error',
            title: 'Error!',
            text: message,
        });
    },
};
